<?php

namespace Database\Factories;

use App\Enums\TagStatus;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            ...$this->translatedAttributes(),
            'slug' => $this->faker->unique()->slug(),
            'status' => $this->faker->randomElement(TagStatus::cases()),
            'created_at' => Carbon::now(),
        ];
    }

    protected function translatedAttributes(): array
    {
        $attributes = [];
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key] = [
                'name' => fake('ar')->name
            ];
        }

        return $attributes;
    }
}
