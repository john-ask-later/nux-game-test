<?php

use App\Domain\Landing\Cron\PruneExpiredLandings;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})
    ->purpose('Display an inspiring quote')
    ->hourly()
    ->appendOutputTo(storage_path('logs/cron.log'));

Schedule::command(PruneExpiredLandings::class)->hourly();
