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
    }
}
