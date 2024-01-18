<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            ...$this->translatedAttributes(),
            'slug' => $this->faker->slug(4),
            'store_id' => Store::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(ProductStatus::cases()),
            'price' => $this->faker->randomFloat(2, 1, 500),
            'compare_price' => $this->faker->randomFloat(2, 500, 999),
            'qty' => $this->faker->randomNumber(2, true),
            'category_id' => Category::inRandomOrder()->first()->id,
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'feature' => $this->faker->boolean,
            'viewed' => $this->faker->numberBetween(5, 100),
            'created_at' => Carbon::now(),
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
