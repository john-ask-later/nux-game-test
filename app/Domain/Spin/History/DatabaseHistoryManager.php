<?php

namespace App\Domain\Spin\History;

use App\Domain\Landing\LandingCrudService;
use App\Domain\Spin\HistoryInterface;
use App\Domain\Spin\Spin;
use App\Domain\Spin\SpinDto;

class DatabaseHistoryManager implements HistoryInterface
{
    public function getSpinsCount(string $landingHashId): int
    {
        return Spin::whereRelation('landing', 'hash', $landingHashId)->max('num') ?? 0;
    }

    public function saveSpin(SpinDto $spinDto): void
    {
        $landing = app(LandingCrudService::class)->findByHash($spinDto->landing_hash_id);

        Spin::create([
            'landing_id' => $landing->id,
            'num'        => $spinDto->num,
            'score'      => $spinDto->score,
            'amount'     => $spinDto->amount,
        ]);

        $landing->touch();
    }

    public function getLatest(string $landingHashId): array
    {
        return Spin::query()
            ->latest('id')
            ->whereRelation('landing', 'hash', $landingHashId)
            ->with('landing')
            ->take(3)
            ->get()
            ->transform(fn(Spin $spin) => $spin->toDto())
            ->all();
    }

}
