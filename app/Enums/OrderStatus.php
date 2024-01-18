<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 1;
    case PROCESSING = 2;
    case DELIVERING = 3;
    case COMPLETED = 4;
    case CANCELLED = 5;
    case REFUNDED = 6;
}
