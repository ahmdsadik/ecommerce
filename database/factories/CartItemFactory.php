<?php

namespace Database\Factories;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'cart_id' => $this->faker->randomNumber(),
            'product_id' => $this->faker->randomNumber(),
            'qry' => $this->faker->randomNumber(),
        ];
    }
}
