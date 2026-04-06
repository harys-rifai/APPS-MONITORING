<?php

namespace App\Events;

use App\Models\Database;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatabaseSpikeDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Database $database,
        public array $metrics
    ) {}
}