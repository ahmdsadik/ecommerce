<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Faker\Provider\Image;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory(10)
            ->create()
            ->each(function (Product $product) {
                $product->tags()->attach(Tag::inRandomOrder()->take(rand(1, 5))->pluck('id'));
//                $product->addMediaFromUrl(Image::imageUrl())->toMediaCollection('logo');
            });
    }
}
