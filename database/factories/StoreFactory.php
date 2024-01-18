<?php

namespace Database\Factories;

use App\Enums\StoreStatus;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition()
    {
        return [
            ...$this->translatedAttributes(),
            'slug' => $this->faker->slug(),
            'owner_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(StoreStatus::cases()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    protected function translatedAttributes(): array
    {
        $attributes = [];
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key] = [
                'name' => $this->faker->productName,
                'description' => fake($key)->sentences(6, true),
                'short_description' => fake($key)->sentences(asText: true),
            ];
        }

        return $attributes;
    }
}
