<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotHandleController extends Controller
{
    public function webhook()
    {
        $update = Telegram::commandsHandler(true);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
