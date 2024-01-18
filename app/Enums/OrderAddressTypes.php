<?php

namespace App\Enums;

enum OrderAddressTypes: int
{
    case BILLING = 1;
    case SHIPPING = 2;
}
