<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::create(
            [
                'name' => 'Admin name',
                'email' => 'admin@example.com',
                'password' => 'password'
            ]
        );

        $admin->addRole(1);
    }
}
