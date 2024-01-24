<?php

namespace Payment\Drivers;

interface PaymentDriverContract
{
    public function pay();
    public function refund();

}