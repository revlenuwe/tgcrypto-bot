<?php

namespace App\Http\Controllers\BotCommands;

use App\Services\BlockchainService;
use App\Traits\BotMessageFormatter;
use App\Traits\HasArguments;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class BalanceCommand extends Command
{

    use BotMessageFormatter,HasArguments;
    /**
     * @var string Command Name
     */
    protected $name = "balance";

    /**
     * @var string Command Description
     */
    protected $description = "...";

    protected $pattern = "{address}";

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

        $data = $this->blockchain->getAddressBalance($this->getArguments()['address']);

        if(!$data) {
            return $this->replyWithMessage([
                'text' => "Error while getting information \n(Perhaps the address does not exist)",
                'parse_mode' => 'html'
            ]);
        }

        $message = "<b>Address: </b><code>".$data['address']."</code>\nCurrent balance: <code>".$data['balance']."</code>\nSpent: <code>".$data['spent']."</code>\nReceived: <code>".$data['received']."</code>\nTransactions: <code>".$data['transactions_count']."</code>";

        $this->replyWithMessage([
            'text' => $message,
            'parse_mode' => 'html'
        ]);
    }
}
