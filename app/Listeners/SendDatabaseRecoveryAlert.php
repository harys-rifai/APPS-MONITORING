<?php

namespace App\Listeners;

use App\Events\DatabaseRecovered;
use App\Models\Alert;
use App\Models\Database;
use App\Notifications\RecoveryAlertNotification;
use Illuminate\Support\Facades\Notification;

class SendDatabaseRecoveryAlert
{
    public function handle(DatabaseRecovered $event): void
    {
        $message = "Database {$event->database->name} ({$event->database->type}) has recovered.\n";
        $message .= "Current metrics:\n";
        $message .= "Active: {$event->metrics['active']}\n";
        $message .= "Idle: {$event->metrics['idle']}\n";
        $message .= "Locked: {$event->metrics['locked']}";

        Alert::create([
            'alertable_type' => Database::class,
            'alertable_id' => $event->database->id,
            'type' => 'db',
            'status' => 'ok',
            'message' => $message,
            'metrics' => $event->metrics,
        ]);

        Notification::route('mail', config('mail.from.address'))->notify(new RecoveryAlertNotification($event->database, $event->metrics, 'database'));
    }
}