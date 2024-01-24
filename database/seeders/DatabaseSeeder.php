<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                LaratrustSeeder::class,
                AdminSeeder::class,
                UserSeeder::class,
                CategorySeeder::class,
                StoreSeeder::class,
                TagSeeder::class,
                ProductSeeder::class,
                OrderSeeder::class,
                OrderItemSeeder::class,
            ]
        );
    }
}
