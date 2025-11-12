<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Has full access to all features',
            ],
            [
                'name' => 'karyawan',
                'display_name' => 'Karyawan',
                'description' => 'Has limited administrative access',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']], // Cari berdasarkan name
                $role // Update atau create dengan data ini
            );
        }
    }
}
