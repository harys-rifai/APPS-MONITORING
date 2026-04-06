<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TelegramChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        if (!$notification instanceof SpikeAlertNotification && 
            !$notification instanceof RecoveryAlertNotification) {
            return;
        }

        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$botToken || !$chatId) {
            return;
        }

        $method = $notification instanceof SpikeAlertNotification 
            ? $notification->toTelegram() 
            : $notification->toTelegram();

        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $method['text'],
            'parse_mode' => $method['parse_mode'] ?? 'Markdown',
        ]);
    }
}