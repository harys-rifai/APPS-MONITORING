<?php

namespace App\Console;

use App\Jobs\CheckDatabaseMetrics;
use App\Jobs\CheckServerMetrics;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new CheckServerMetrics())->everyMinute();
        $schedule->job(new CheckDatabaseMetrics())->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}