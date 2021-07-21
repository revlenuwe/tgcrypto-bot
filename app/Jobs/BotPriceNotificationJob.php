<?php

namespace App\Jobs;

use App\Services\CoingeckoService;
use App\Traits\BotMessageFormatter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotPriceNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BotMessageFormatter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param CoingeckoService $gecko
     * @return void
     * @throws \Exception
     */
    public function handle(CoingeckoService $gecko)
    {
        $data = $gecko->getCoinData(config('crypto-bot.main_currency'));

        $message = $this->coinInfoMessage($data);

        Telegram::sendMessage([
            'chat_id' => config('crypto-bot.notifications_telegram_id'),
            'text' => $message,
            'parse_mode' => 'html',
        ]);
    }
}
