<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {

        return [
            ...$this->translatedAttributes(),
            'slug' => $this->faker->unique()->slug(),
            'status' => $this->faker->randomElement(CategoryStatus::cases()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    protected function translatedAttributes(): array
    {
        $attributes = [];
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key] = [
                'name' => $this->faker->category,
                'description' => fake($key)->sentences(asText: true)
            ];
        }

        return $attributes;
    }
}
