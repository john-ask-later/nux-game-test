<?php

namespace App\Domain\Spin\History;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\RedisManager;

class SpinsPresenceVerifier
{
    protected Connection $connection;

    public function __construct(
        RedisManager $manager,
    ) {
        $this->connection = $manager->connection('spins');
    }

    public function getPresenceKey(string $landingHashId): string
    {
        return "landing_exists:{$landingHashId}";
    }

    public function exists(string $landingHashId): bool
    {
        return $this->connection->exists(
            $this->getPresenceKey($landingHashId)
        );
    }

    public function add(string $landingHashId): void
    {
        $this->connection->set(
            $this->getPresenceKey($landingHashId),
            true
        );
    }

}
