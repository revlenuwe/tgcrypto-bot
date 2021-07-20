<?php


namespace App\Services;


use Codenixsv\CoinGeckoApi\CoinGeckoClient;

class CoingeckoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new CoinGeckoClient();
    }

    /**
     * @param string $from
     * @param string $to
     * @param float|null $amount
     * @return false|float|int|mixed
     * @throws \Exception
     */
    public function convertCurrency(string $from, string $to, float $amount = null)
    {
        if (!$this->supportConversion($to)) {
            return false;
        }

        $data = $this->client->simple()->getPrice($from, $to);

        if (!$amount) {
            return $data[$from][$to];
        }

        return $data[$from][$to] * $amount;
    }

    /**
     * @param string $cryptoCurrency
     * @param string $currency
     * @return array|false|mixed
     * @throws \Exception
     */
    public function getCoinData(string $cryptoCurrency, string $currency = 'usd')
    {
        $allMarkets = $this->client->coins()->getMarkets($currency);

        if($cryptoCurrency) {
            if(!$this->supportConversion($cryptoCurrency)) {
                return false;//exception
            }

            return collect($allMarkets)->firstWhere('symbol', $cryptoCurrency);
        }

        return $allMarkets;
    }

    /**
     * @param string $to
     * @return bool
     * @throws \Exception
     */
    public function supportConversion(string $to) : bool
    {
        $supportedCurrencies = $this->client->simple()->getSupportedVsCurrencies();

        return in_array($to, $supportedCurrencies);
    }

}