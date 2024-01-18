<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private string $api_key;
    protected string $base_url = 'https://api.currencyfreaks.com/v2.0';

    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;
    }

    public function convert(string $from, string $to, int $amount = 1): ?float
    {
        $response = Http::baseUrl($this->base_url)
            ->get('/rates/latest', [
                'apikey' => $this->api_key,
                'symbols' => $to,
                'base' => $from
            ]);

        try {
            $rate = $response->json()['rates'][$to];
        } catch (\Exception $e) {
            return null;
        }
        return $rate;
    }
}
