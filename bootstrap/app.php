<?php

use App\Domain\Landing\Cron\PruneExpiredLandings;
use App\Domain\Landing\VerifyLandingMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'landing_active' => VerifyLandingMiddleware::class,
        ]);
    })->withExceptions(function (Exceptions $exceptions) {
        //
    })->withCommands([
        PruneExpiredLandings::class,
    ])->create();
