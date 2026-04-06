<?php

namespace App\Console;

use App\Jobs\CheckDatabaseMetrics;
use App\Jobs\CheckServerMetrics;
use App\Jobs\SyncToStaging;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new CheckServerMetrics())->everyMinute();
        $schedule->job(new CheckDatabaseMetrics())->everyMinute();
        $schedule->job(new SyncToStaging())->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}