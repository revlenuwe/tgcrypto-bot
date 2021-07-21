<?php

namespace App\Http\Controllers\BotCommands;

use App\Services\CoingeckoService;
use App\Services\GeckoApiService;
use App\Traits\BotMessageFormatter;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class PriceCommand extends Command
{

    use BotMessageFormatter;
    /**
     * @var string Command Name
     */
    protected $name = "price";

    /**
     * @var string Command Description
     */
    protected $description = "...";

    protected $pattern = "{currency}";

    protected $gecko;

    public function __construct(CoingeckoService $gecko) {
        $this->gecko = $gecko;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $currency = !empty($this->getArguments()) ? $this->getArguments()['currency'] : config('crypto-bot.main_currency');

        $data = $this->gecko->getCoinData($currency);

        if(!$data) {
            return $this->replyWithMessage([
                'text' => 'Currency is not supported'
            ]);
        }

        $message = $this->coinInfoMessage($data);

        $this->replyWithMessage([
            'text' => $message,
            'parse_mode' => 'html'
        ]);
    }
}
