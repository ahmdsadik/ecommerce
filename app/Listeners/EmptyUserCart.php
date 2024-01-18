<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyUserCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }



    /**
     * Determine whether the listener should be queued.
     */
    public function shouldQueue(OrderCreated $event): bool
    {
        return Cart::get()->count() >= 200;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        Cart::empty();
    }
}
