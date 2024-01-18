<?php

namespace Database\Seeders;

use App\Models\Store;
use Faker\Provider\Image;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::factory(10)->create()->each(function (Store $store) {
//            $store->addMediaFromUrl(Image::imageUrl())->toMediaCollection('logo');
        });
    }
}
