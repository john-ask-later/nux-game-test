<?php

namespace App\Domain\Landing;

/**
 * Save model state to cache on fetching/saving/soft deleting.
 * @see LandingCachingService
 */
class LandingObserver
{
    public function __construct(
        protected LandingCachingService $cache
    ) {
    }

    public function retrieved(Landing $model)
    {
        $this->cache->save($model);
    }

    public function saved(Landing $model)
    {
        $this->cache->save($model);
    }

    public function deleted(Landing $model)
    {
        $this->cache->save($model);
    }

}
