<?php


namespace App\Services;


use Blockchain\Blockchain;

class BlockchainService
{

    protected $client;

    public function __construct()
    {
        $this->client = new Blockchain();
    }

    public function toBtc($amount, $currency = 'usd')
    {
        $data = $this->client->Rates->toBTC($amount, $currency);

        if(!$data) {
            return false;
        }

        return $data;
    }

    public function getAddressBalance($address)
    {
        $data = $this->client->Explorer->getAddress($address);

        if(!$data->address) {
            return false;
        }

        return [
            'spent' => $data->total_sent,
            'received' => $data->total_received,
            'balance' => $data->final_balance,
            'transactions_count' => count($data->transactions)
        ];
    }
}
