<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::factory(10)->create();

        $orders = Order::with('items')->get();
        foreach ($orders as $order) {

//            $total = $order->products->sum(function (Product $product) {
//                return $product->order_details->qty * $product->order_details->price;
//            });

            $total = $order->items->sum(fn(OrderItem $orderItem) => $orderItem->total);

            $order->update(['total' => $total]);
        }
    }
}
