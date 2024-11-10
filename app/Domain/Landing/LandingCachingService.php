<?php

namespace App\Domain\Landing;

use Illuminate\Cache\CacheManager;

/**
 * Helper to put model into cache for 1 day, and find it by hash ID.
 */
class LandingCachingService
{
    public function __construct(
        protected CacheManager $cache
    ) {

    }

    public function find(string $hashId): ?Landing
    {
        $dto = $this->cache->get(
            $this->getCacheKey($hashId)
        );

        if ($dto) {
            return Landing::newFromDto($dto);
        }

        return null;
    }

    public function save(Landing $model)
    {
        $this->cache->put(
            $this->getCacheKey($model->hash),
            $model->toDto(),
            60 * 60 * 24
        );
    }

    protected function getCacheKey(string $hashId): string
    {
        return "landing_pages.{$hashId}";
    }

}
