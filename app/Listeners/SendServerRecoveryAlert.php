<?php

namespace App\Listeners;

use App\Events\ServerRecovered;
use App\Models\Alert;
use App\Models\Server;
use App\Notifications\RecoveryAlertNotification;
use Illuminate\Support\Facades\Notification;

class SendServerRecoveryAlert
{
    public function handle(ServerRecovered $event): void
    {
        $message = "Server {$event->server->name} ({$event->server->ip}) has recovered.\n";
        $message .= "Current metrics:\n";
        $message .= "CPU: {$event->metrics['cpu']}%\n";
        $message .= "RAM: {$event->metrics['ram']}%\n";
        $message .= "Disk: {$event->metrics['disk']}%";

        Alert::create([
            'alertable_type' => Server::class,
            'alertable_id' => $event->server->id,
            'type' => 'server',
            'status' => 'ok',
            'message' => $message,
            'metrics' => $event->metrics,
        ]);

        Notification::route('mail', config('mail.from.address'))->notify(new RecoveryAlertNotification($event->server, $event->metrics, 'server'));
    }
}