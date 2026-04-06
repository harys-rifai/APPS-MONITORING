<?php

namespace App\Listeners;

use App\Events\ServerSpikeDetected;
use App\Models\Alert;
use App\Models\Server;
use App\Notifications\SpikeAlertNotification;
use Illuminate\Support\Facades\Notification;

class SendServerSpikeAlert
{
    public function handle(ServerSpikeDetected $event): void
    {
        $message = "Server {$event->server->name} ({$event->server->ip}) is experiencing a spike!\n";
        $message .= "CPU: {$event->metrics['cpu']}% (threshold: {$event->server->cpu_threshold}%)\n";
        $message .= "RAM: {$event->metrics['ram']}% (threshold: {$event->server->ram_threshold}%)\n";
        $message .= "Disk: {$event->metrics['disk']}% (threshold: {$event->server->disk_threshold}%)";

        Alert::create([
            'alertable_type' => Server::class,
            'alertable_id' => $event->server->id,
            'type' => 'server',
            'status' => 'spike',
            'message' => $message,
            'metrics' => $event->metrics,
        ]);

        Notification::route('mail', config('mail.from.address'))->notify(new SpikeAlertNotification($event->server, $event->metrics, 'server'));
    }
}