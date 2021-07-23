<?php

namespace App\Http\Controllers\BotCommands;

use App\Services\BlockchainService;
use App\Traits\BotMessageFormatter;
use App\Traits\HasArguments;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ToBtcCommand extends Command
{

    use BotMessageFormatter,HasArguments;

    /**
     * @var string Command Name
     */
    protected $name = "btc";

    /**
     * @var string Command Description
     */
    protected $description = "...";

    protected $pattern = "{amount}";

    protected $blockchain;

    public function __construct(BlockchainService $blockchain)
    {
        $this->blockchain = $blockchain;
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

        $data = $this->blockchain->toBtc($this->getArguments()['amount']);

        if(!$data) {
            return $this->replyWithMessage([
                'text' => 'Conversion error, please try later'
            ]);
        }

        $message = $this->convertInfoMessage([
            'amount' => $this->getArguments()['amount'],
            'price' => $data,
            'from' => 'USD',
            'to' => 'BTC',
        ]);

        return $this->replyWithMessage([
            'text' => $message,
            'parse_mode' => 'html'
        ]);

    }
}
