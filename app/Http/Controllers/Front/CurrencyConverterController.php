<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => ['string', 'size:3', 'required']
        ]);

        $base_currency_code = config('app.currency');
        $currency_code = $request->post('currency_code');

        $cache_key = 'currency_rate_' . $currency_code;


        cache()->remember($cache_key, now()->addMinutes(60), function () use ($base_currency_code, $currency_code) {
            $converter = new CurrencyConverter(getenv('CURRENCY_FREAKS_API_KEY'));
            return $converter->convert($base_currency_code, $currency_code);
        });

        session()->put('currency_code', $currency_code);

        return back();
    }
}
