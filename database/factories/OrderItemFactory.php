<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $qty = $this->faker->randomNumber(1, true);
        $price = $this->faker->randomFloat(2, 1, 500);

        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'store_id' => Store::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'product_name' => $this->faker->productName,
            'qty' => $qty,
            'price' => $price,
            'total' => $qty * $price,
            'option' => $this->faker->words(),
        ];
    }
}
