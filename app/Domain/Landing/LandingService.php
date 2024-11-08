<?php

namespace App\Domain\Landing;

use Illuminate\Support\Str;

class LandingService
{
    public function create(int $playerId): Landing
    {
        return Landing::create([
            'player_id' => $playerId,
            'hash'      => Str::uuid(),
        ]);
    }

    public function findByHash(string $hashId): Landing
    {
        return Landing::withTrashed()
            ->where('hash', $hashId)
            ->firstOrFail();
    }

    public function deactivate(Landing $page): void
    {
        $page->delete();
    }

    public function regenerate(Landing $page): Landing
    {
        return Landing::create([
            'player_id' => $page->player_id,
            'hash'      => Str::uuid(),
        ]);
    }

}
