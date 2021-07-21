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
        $from = $this->getCoinBySymbol($from);

        if (!$this->supportConversion($to) || !$from) {
            return false;
        }

        $data = $this->client->simple()->getPrice($from['id'], $to);

        if (!$amount) {
            return $data[$from['id']][$to];
        }

        return $data[$from['id']][$to] * $amount;
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
            if(!$this->isCoinSupported($cryptoCurrency)) {
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

    /**
     * @param $coinSymbol
     * @return bool
     * @throws \Exception
     */
    public function isCoinSupported($coinSymbol) : bool
    {
        $coinsList = collect($this->client->coins()->getList());

        return $coinsList->contains('symbol', $coinSymbol);
    }

    /**
     * @param $coinSymbol
     * @return false|mixed
     * @throws \Exception
     */
    private function getCoinBySymbol($coinSymbol)
    {
        $coinsList = collect($this->client->coins()->getList());

        if(!$coinsList->contains('symbol', $coinSymbol)) {
            return false;
        }

        return $coinsList->firstWhere('symbol', $coinSymbol);
    }

}
