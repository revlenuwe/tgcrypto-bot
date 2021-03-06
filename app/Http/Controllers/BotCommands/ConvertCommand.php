<?php

namespace App\Http\Controllers\BotCommands;

use App\Services\CoingeckoService;
use App\Traits\BotMessageFormatter;
use App\Traits\HasArguments;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ConvertCommand extends Command
{

    use BotMessageFormatter,HasArguments;
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
        if(!$this->checkArguments()) {
            return $this->replyWithMessage([
                'text' => $this->missArgumentsMessage()
            ]);
        }

        $arguments = $this->getArguments();

        $price = $this->gecko->convertCurrency($arguments['from'], $arguments['to'], $arguments['amount']);
        $arguments['price'] = $price;

        if(!$price) {
            return $this->replyWithMessage([
                'text' => 'Unable to convert currency'
            ]);
        }

        $message = $this->convertInfoMessage($arguments);

        $this->replyWithMessage([
            'text' => $message
        ]);
    }
}
