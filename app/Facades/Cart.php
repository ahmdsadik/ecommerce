<?php

namespace App\Facades;

use App\Repositories\Cart\CartModelRepository;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CartModelRepository::class;
    }
}
