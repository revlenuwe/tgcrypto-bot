<?php


namespace App\Traits;


trait BotMessageFormatter
{

    /**
     * @param $data
     * @return string
     */
    public function coinInfoMessage(array $data) : string
    {
        $symbol = strtoupper($data['symbol']);
        $roundedPrice = round($data['current_price'], 4);
        $roundedPercentage = round($data['price_change_percentage_24h'], 3);

        return "<b>" . $symbol . "</b>: $" . $roundedPrice . " (" . $roundedPercentage . "%)\n24h: Low $" . $data['low_24h'] . ' | High $' . $data['high_24h'] . "\n\n";
    }

    public function missArgumentsMessage() : string
    {
        return 'Some arguments are missing';
    }

    public function transactionInfoMessage(array $data) : string
    {
        return "<b>Address: </b><code>".$data['address']."</code>\nCurrent balance: <code>".$data['balance']."</code>\nSpent: <code>".$data['spent']."</code>\nReceived: <code>".$data['received']."</code>\nTransactions: <code>".$data['transactions_count']."</code>";
    }

    public function convertInfoMessage(array $data) : string
    {
        return $data['amount'] ." ".strtoupper($data['from'])." = ". number_format($data['price'], 2,',',' ')." ". strtoupper($data['to']);
    }
}
