<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user - always active
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@presensi.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'jabatan_id' => null,
            'lokasi_id' => null,
            'alamat' => 'Kantor Pusat',
            'is_active' => true  // Admin selalu aktif
        ]);

        // Create sample active karyawan
        User::create([
            'nama' => 'John Doe',
            'email' => 'john@presensi.com',
            'password' => Hash::make('karyawan123'),
            'role_id' => 2, // Karyawan role
            'jabatan_id' => 1,
            'lokasi_id' => 1,
            'alamat' => 'Jl. Contoh No. 123',
            'is_active' => true
        ]);

        // Create sample pending karyawan (untuk demo)
        User::create([
            'nama' => 'Jane Smith',
            'email' => 'jane@presensi.com',
            'password' => Hash::make('karyawan123'),
            'role_id' => 2, // Karyawan role
            'jabatan_id' => 2,
            'lokasi_id' => 1,
            'alamat' => 'Jl. Sample No. 456',
            'is_active' => false  // Pending activation
        ]);

        // Create another pending karyawan
        User::create([
            'nama' => 'Ahmad Rahman',
            'email' => 'ahmad@presensi.com',
            'password' => Hash::make('karyawan123'),
            'role_id' => 2,
            'jabatan_id' => 3,
            'lokasi_id' => 2,
            'alamat' => 'Jl. Baru No. 789',
            'is_active' => false  // Pending activation
        ]);
    }
}
