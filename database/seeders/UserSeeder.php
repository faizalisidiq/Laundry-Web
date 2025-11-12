<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@laundry.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role_id' => 1,
                'phone' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role_id' => 2,
                'phone' => '081234567891',
            ]
        );
    }
}