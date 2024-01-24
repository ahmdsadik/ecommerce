<?php

namespace Payment;

use Illuminate\Support\Manager;
use Payment\Drivers\PaymentDriverContract;
use Payment\Drivers\StripeDriver;

class PaymentGatewayManager extends Manager
{

    /**
     * @inheritDoc
     */
    public function getDefaultDriver(): string
    {
        return 'Stripe';
    }

    public function createStripeDriver(): PaymentDriverContract
    {
        return new StripeDriver();
    }


}