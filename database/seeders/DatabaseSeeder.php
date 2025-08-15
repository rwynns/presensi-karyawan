<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run specific seeders in correct order
        $this->call([
            RoleSeeder::class,           // Must be first (creates roles)
            JabatanSeeder::class,        // Creates jabatan data
            LokasiPenempatanSeeder::class, // Creates lokasi data
            AdminUserSeeder::class,      // Depends on roles, jabatan, and lokasi being created
        ]);
    }
}
