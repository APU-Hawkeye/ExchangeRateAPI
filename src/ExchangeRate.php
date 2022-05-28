<?php
declare(strict_types=1);

class ExchangeRate
{
    public function showExchangeRate(string $targetCurrency)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $endpoint = 'latest';
            $accessKey = '';
            $baseCurrency = 'EUR';
            $response = $client->request(
                'GET',
                'https://data.fixer.io/api/'.$endpoint.'?access_key='.$accessKey.'&base='.$baseCurrency.'&symbols='.$targetCurrency
            );
            if ($response->getStatusCode() === 200) {
                /** @var array $json */
                $json = json_decode($response->getBody()->getContents(), true);

                return [
                    'rate' => $json['rates'][$targetCurrency]
                ];
            }
        } catch (InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }


    public function showAmount(string $targetCurrency, float $amount)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $endpoint = 'convert';
            $accessKey = '';
            $baseCurrency = 'EUR';
            /** @var \GuzzleHttp\Psr7\Response $response */
            $response = $client->request(
                'GET',
                'https://data.fixer.io/api/'.$endpoint.'?access_key='.$accessKey.'&from='.$baseCurrency.'$to='.$targetCurrency.'$amount='.$amount
            );
            if ($response->getStatusCode() === 200) {
                /** @var array $json */
                $json = json_decode($response->getBody()->getContents(), true);

                return [
                    'amount' => $json['result']
                ];
            }
        } catch (InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }
}