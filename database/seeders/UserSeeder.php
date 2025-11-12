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
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123'),
                'role_id' => 1,
                'phone' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['email' => 'karyawan@laundry.com'],
            [
                'name' => 'Karyawan',
                'password' => Hash::make('123'),
                'role_id' => 2,
                'phone' => '081234567891',
            ]
        );
    }
}
