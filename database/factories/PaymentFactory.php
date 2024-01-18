<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'order_id' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomFloat(),
            'currency' => $this->faker->word(),
            'method' => $this->faker->word(),
            'status' => $this->faker->word(),
            'transaction_id' => $this->faker->word(),
            'transaction_data' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
