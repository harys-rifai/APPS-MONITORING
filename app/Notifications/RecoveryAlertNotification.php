<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecoveryAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $alertable,
        public array $metrics,
        public string $type
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $title = $this->type === 'server' ? 'Server Recovery' : 'Database Recovery';
        $name = $this->alertable->name;

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject("[OK] {$title}: {$name}")
            ->line("{$title} for {$name}.")
            ->line($this->type === 'server' ? $this->buildServerMessage() : $this->buildDatabaseMessage())
            ->line('Timestamp: ' . now()->format('Y-m-d H:i:s'));
    }

    private function buildServerMessage(): string
    {
        return "CPU: {$this->metrics['cpu']}%\nRAM: {$this->metrics['ram']}%\nDisk: {$this->metrics['disk']}%";
    }

    private function buildDatabaseMessage(): string
    {
        return "Active: {$this->metrics['active']}\nIdle: {$this->metrics['idle']}\nLocked: {$this->metrics['locked']}";
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->type === 'server' ? 'Server Recovered' : 'Database Recovered',
            'alertable_type' => get_class($this->alertable),
            'alertable_id' => $this->alertable->id,
            'metrics' => $this->metrics,
            'type' => $this->type,
            'status' => 'ok',
        ];
    }

    public function toTelegram(): array
    {
        $title = $this->type === 'server' ? 'Server Recovery' : 'Database Recovery';
        $name = $this->alertable->name;
        $message = "✅ *{$title}*\n\n";
        $message .= "Name: {$name}\n";
        
        if ($this->type === 'server') {
            $message .= "CPU: {$this->metrics['cpu']}%\nRAM: {$this->metrics['ram']}%\nDisk: {$this->metrics['disk']}%";
        } else {
            $message .= "Active: {$this->metrics['active']}\nIdle: {$this->metrics['idle']}\nLocked: {$this->metrics['locked']}";
        }

        return [
            'text' => $message,
            'parse_mode' => 'Markdown',
        ];
    }

    public function toWebhook(): array
    {
        return [
            'alert_type' => 'recovery',
            'entity_type' => $this->type,
            'entity_name' => $this->alertable->name,
            'metrics' => $this->metrics,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}