<?php

namespace App\Providers;

use App\Domain\Spin\History\DatabaseHistoryManager;
use App\Domain\Spin\History\RedisHistoryManager;
use App\Domain\Spin\History\SpinsPresenceVerifier;
use App\Domain\Spin\HistoryInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Build history manager depends on config value
        if ($this->app['config']->get('domain.history_manager') === 'redis') {
            $this->app->bind(HistoryInterface::class, function () {
                return new RedisHistoryManager(
                    $this->app['redis'],
                    $this->app->make(DatabaseHistoryManager::class),
                    $this->app->make(SpinsPresenceVerifier::class)
                );
            });
        } else {
            $this->app->bind(HistoryInterface::class, DatabaseHistoryManager::class);
        }

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }

}
