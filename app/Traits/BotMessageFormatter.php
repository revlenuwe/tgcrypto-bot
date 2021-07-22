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
}
