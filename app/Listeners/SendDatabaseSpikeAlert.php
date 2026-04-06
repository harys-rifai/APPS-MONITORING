<?php

namespace App\Listeners;

use App\Events\DatabaseSpikeDetected;
use App\Models\Alert;
use App\Models\Database;
use App\Notifications\SpikeAlertNotification;
use Illuminate\Support\Facades\Notification;

class SendDatabaseSpikeAlert
{
    public function handle(DatabaseSpikeDetected $event): void
    {
        $message = "Database {$event->database->name} ({$event->database->type}) is experiencing a spike!\n";
        $message .= "Active queries: {$event->metrics['active']} (threshold: {$event->database->active_threshold})\n";
        $message .= "Idle queries: {$event->metrics['idle']} (threshold: {$event->database->idle_threshold})\n";
        $message .= "Locked queries: {$event->metrics['locked']} (threshold: {$event->database->lock_threshold})";

        Alert::create([
            'alertable_type' => Database::class,
            'alertable_id' => $event->database->id,
            'type' => 'db',
            'status' => 'spike',
            'message' => $message,
            'metrics' => $event->metrics,
        ]);

        Notification::route('mail', config('mail.from.address'))->notify(new SpikeAlertNotification($event->database, $event->metrics, 'database'));
    }
}