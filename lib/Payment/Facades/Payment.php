<?php

namespace Payment\Facades;

use Illuminate\Support\Facades\Facade;
use Payment\Drivers\PaymentDriverContract;
use Payment\PaymentGatewayManager;

class Payment extends Facade
{

    /**
     *
     * @method static PaymentDriverContract driver(string $key)
     *
     * @see PaymentGatewayManager
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return PaymentGatewayManager::class;
    }
}