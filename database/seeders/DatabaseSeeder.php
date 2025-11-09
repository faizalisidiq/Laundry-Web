<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            // AdminSeeder::class, // jika ada
            // DatabaseSeeder::class, // seeder lainnya
        ]);
    }
}
