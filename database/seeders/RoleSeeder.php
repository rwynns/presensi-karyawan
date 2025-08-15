<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Roles - Hanya 2 role untuk sistem presensi
        $roles = [
            ['nama_role' => 'Admin'],
            ['nama_role' => 'Karyawan'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['nama_role' => $role['nama_role']],
                $role
            );
        }
    }
}
