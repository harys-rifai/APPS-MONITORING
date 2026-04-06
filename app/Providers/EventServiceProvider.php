<?php

namespace App\Providers;

use App\Events\DatabaseRecovered;
use App\Events\DatabaseSpikeDetected;
use App\Events\ServerRecovered;
use App\Events\ServerSpikeDetected;
use App\Listeners\SendDatabaseRecoveryAlert;
use App\Listeners\SendDatabaseSpikeAlert;
use App\Listeners\SendServerRecoveryAlert;
use App\Listeners\SendServerSpikeAlert;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ServerSpikeDetected::class => [
            SendServerSpikeAlert::class,
        ],
        ServerRecovered::class => [
            SendServerRecoveryAlert::class,
        ],
        DatabaseSpikeDetected::class => [
            SendDatabaseSpikeAlert::class,
        ],
        DatabaseRecovered::class => [
            SendDatabaseRecoveryAlert::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}