<?php

namespace App\Domain\Spin;

use Illuminate\Database\Eloquent\Collection;

class SpinHistoryService
{
    public function getLatest(int $landingId): Collection
    {
        return Spin::query()
            ->latest('id')
            ->where('landing_id', $landingId)
            ->take(3)
            ->get();
    }
}
