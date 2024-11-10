<?php

namespace App\Domain\Spin\Jobs;

use App\Domain\Spin\History\DatabaseHistoryManager;
use App\Domain\Spin\SpinDto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

/**
 * Simple Job for "delayed writing". If we use redis history manager - we must avoid database queries as much as
 * possible, but we stil must persist data to database. We will do it in background to prevent customers wait their results
 * on extrem height loading periods.
 */
class SaveSpinJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public SpinDto $spin
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(DatabaseHistoryManager $history): void
    {
        $history->saveSpin($this->spin);
    }

}
