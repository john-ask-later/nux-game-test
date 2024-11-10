<?php

namespace App\Domain\Spin\History;

use App\Domain\Spin\HistoryInterface;
use App\Domain\Spin\Jobs\SaveSpinJob;
use App\Domain\Spin\SpinDto;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Arr;

/**
 * Redis database history manager. Build as decorator around database manager.
 */
class RedisHistoryManager implements HistoryInterface
{
    protected Connection $connection;

    protected int $historyLength;

    public function __construct(
        RedisManager $manager,
        protected HistoryInterface $database,
        protected SpinsPresenceVerifier $verifier,
    ) {
        $this->connection    = $manager->connection('spins');
        $this->historyLength = config('domain.history_length');
    }

    public function getSpinsCount(string $landingHashId): int
    {
        $lastSpin = Arr::first($this->getLatest($landingHashId));

        // Get order number from last spin or 0 if there were no spins yet
        return $lastSpin?->num ?? 0;
    }

    public function saveSpin(SpinDto $spinDto): void
    {
        $hashId = $spinDto->landing_hash_id;
        $key    = $this->getSpinsKey($hashId);

        $this->connection->lpush($key, $spinDto->toJson());

        if ($this->connection->llen($key) > $this->historyLength) {
            $this->connection->rpop($key);
        }

        // Fire job to write spin into database
        dispatch(new SaveSpinJob($spinDto));
    }

    public function getLatest(string $landingHashId): array
    {
        // Fil catcher: some extra situation, when landing hash id wasn't added to redis after landing creating
        if (false === $this->verifier->exists($landingHashId)) {

            // Get list of spins from database
            $spins = $this->database->getLatest($landingHashId);

            // Push each of spins (reverse list to keep the logic of ->lpush()) into memory
            foreach (array_reverse($spins) as $spin) {
                $this->saveSpin($spin);
            }

            // Instruct code that everything is fine now
            $this->verifier->add($landingHashId);

            return $spins;
        }

        // Fetch list and convert json strings into DTOs
        $key   = $this->getSpinsKey($landingHashId);
        $spins = $this->connection->lrange($key, 0, -1) ?? [];

        return collect($spins)
            ->map(fn(string $spin) => SpinDto::fromJson($spin))
            ->all();
    }

    public function getSpinsKey(string $landingHashId): string
    {
        return "landing_spins:{$landingHashId}";
    }

}
