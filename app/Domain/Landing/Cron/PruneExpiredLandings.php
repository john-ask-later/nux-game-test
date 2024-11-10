<?php

namespace App\Domain\Landing\Cron;

use App\Domain\Landing\Landing;
use Illuminate\Console\Command;

class PruneExpiredLandings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-expired-landings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Went through landings and soft delete expired pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiration = now()->subDays(config('domain.landing_expiration'));
        $models     = Landing::query()
            ->where('created_at', '<', $expiration)
            ->cursor();

        foreach ($models as $model) {
            $model->delete();
        }
    }

}
