<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotHandleController extends Controller
{
    public function webhook()
    {
        $update = Telegram::commandsHandler(true);

        if(config('crypto-bot.store_messages')) {
            $user = User::where('chat_id', $update->getChat()->id)->first();

            $user->messages()->create([
                'chat_update_id' => $update->updateId,
                'chat_message_id' => $update->getMessage()->messageId,
                'text' => $update->getMessage()->text,
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
