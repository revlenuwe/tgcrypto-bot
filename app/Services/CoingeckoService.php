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
     * @param $from
     * @param $to
     * @return false|mixed
     * @throws \Exception
     */
    public function convertCurrency(string $from, string $to)
    {
        if(!$this->supportConversion($to)) {
            return false;
        }

        $data = $this->client->simple()->getPrice($from, $to);

        return $data[$from][$to];
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
