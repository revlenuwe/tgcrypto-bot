<?php

namespace App\Http\Controllers\BotCommands;

use App\Services\CoingeckoService;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ConvertCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "convert";

    /**
     * @var string Command Description
     */
    protected $description = "...";

    protected $pattern = "{amount} {from} {to}";

    protected $gecko;

    public function __construct(CoingeckoService $gecko) {
        $this->gecko = $gecko;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $arguments = $this->getArguments();

        $price = $this->gecko->convertCurrency($arguments['from'], $arguments['to'], $arguments['amount']);

        if(!$price) {
            $this->replyWithMessage([
                'text' => 'Unable to convert currency'
            ]);
        }

        $text = $arguments['amount'] ." ".strtoupper($arguments['from'])." = ". number_format($price, 2,',',' ')." ". strtoupper($arguments['to']);

        $this->replyWithMessage([
            'text' => $text
        ]);
    }
}
