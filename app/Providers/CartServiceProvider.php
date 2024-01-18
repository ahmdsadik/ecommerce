<?php

namespace App\Providers;

use App\Interfaces\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CartRepository::class, CartModelRepository::class);
    }

    public function boot(): void
    {
    }
}
