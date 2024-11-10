<?php

namespace App\Domain\Landing;

use Illuminate\Support\Str;

class LandingCrudService
{
    public function __construct(
        protected LandingCachingService $cache
    ) {
    }

    /**
     * Create landing page for player with unique hash ID.
     *
     * @param int $playerId
     *
     * @return Landing
     */
    public function create(int $playerId): Landing
    {
        return Landing::create([
            'player_id' => $playerId,
            'hash'      => Str::uuid(),
        ]);
    }

    /**
     * Find landing page (includes soft deleted pages).
     *
     * @param string $hashId
     *
     * @return Landing
     */
    public function findByHash(string $hashId): Landing
    {
        if ($model = $this->cache->find($hashId)) {
            return $model;
        }

        return Landing::withTrashed()
            ->where('hash', $hashId)
            ->firstOrFail();
    }

    /**
     * Run soft delete on landing page to prevent players visits.
     *
     * @param Landing $page
     *
     * @return void
     */
    public function deactivate(Landing $page): void
    {
        $page->delete();
    }

    /**
     * Create new landing page for the same player.
     *
     * @param Landing $page
     *
     * @return Landing
     */
    public function regenerate(Landing $page): Landing
    {
        return $this->create($page->player_id);
    }

}
