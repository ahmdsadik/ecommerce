<?php

namespace App\Helpers;

use NumberFormatter;

class Currency
{
    public static function format($amount, $currency = null): bool|string
    {
        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        $baseCurrency = config('app.currency', 'USD');

        if (!$currency) {
            $currency = session('currency_code', config('app.currency'));
        }

        if ($currency != $baseCurrency) {
            $rate = cache()->get('currency_rate_' . $currency, 1);
            $amount = $amount * $rate;
        }

//        dd(cache()->get('currency_rate_' . $currency, 1));

        return $formatter->formatCurrency($amount, $currency);
    }
}
