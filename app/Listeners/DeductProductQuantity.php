<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DeductProductQuantity implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        try {
            $order = $event->order;
            foreach ($order->products as $product) {
                $product->decrement('qty', $product->order_details->qty);
            }
        }catch (\Exception $exception)
        {
            Log::error('error Happened at ' . __CLASS__);
        }
    }
}
