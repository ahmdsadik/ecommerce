<?php

namespace Payment\Drivers;

class StripeDriver implements PaymentDriverContract
{

    public function pay()
    {
        return 'Stripe Pay Method';
    }

    public function refund()
    {
        return 'Stripe refund Method';
    }
}