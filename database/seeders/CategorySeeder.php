<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Faker\Provider\Image;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(10)->create()->each(function (Category $category) {
//            $category->addMediaFromUrl(Image::imageUrl())->toMediaCollection('logo');
            if (rand(0, 2)) {
                $category->parent_id = Category::whereNot('id', $category->id)->inRandomOrder()->first()->id;
                $category->save();
            }
        });
    }
}
