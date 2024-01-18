<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => 'password'
        ]);

        User::factory(20)->create();

    }
}
