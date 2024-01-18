<?php

namespace App\Enums;

enum ProductStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case DRAFT = 3;
}
