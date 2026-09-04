<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class TelegramAlert extends Notification
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $token = config('services.telegram-bot-api.token');
        $chatId = config('services.telegram-bot-api.chat_id');
        
        if (!$token || !$chatId) {
            \Log::error('Telegram config missing: token=' . ($token ? 'set' : 'missing') . ', chatId=' . ($chatId ? 'set' : 'missing'));
            return null;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        
        $data = [
            'chat_id' => $chatId,
            'text' => $this->content,
            'parse_mode' => 'Markdown'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            \Log::error('Telegram API error: ' . $response);
        } else {
            \Log::info('Telegram message sent successfully');
        }

        return null;
    }
}
