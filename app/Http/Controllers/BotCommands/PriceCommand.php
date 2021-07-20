<?php

namespace App\Http\Controllers\BotCommands;

use App\Services\CoingeckoService;
use App\Services\GeckoApiService;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class PriceCommand extends Command
{
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
        $data = $this->gecko->getCoinData($this->getArguments()['currency']);

        //temp
        $symbol = strtoupper($data['symbol']);
        $roundedPrice = round($data['current_price'],4);
        $roundedPercentage = round($data['price_change_percentage_24h'],3);

        $text = "<b>".$symbol."</b>: $". $roundedPrice ." (".$roundedPercentage."%)\n24h: Low $".$data['low_24h'].' | High $'.$data['high_24h'] . "\n\n";

        if(!$data) {
            $this->replyWithMessage([
                'text' => 'Currency is not supported'
            ]);
        }

        $this->replyWithMessage([
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }
}
