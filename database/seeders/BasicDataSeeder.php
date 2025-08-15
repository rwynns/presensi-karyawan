<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Jabatan;
use App\Models\LokasiPenempatan;

class BasicDataSeeder extends Seeder
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
            Role::create($role);
        }

        // Seed Jabatan
        $jabatan = [
            ['nama_jabatan' => 'Manager', 'kode_jabatan' => 'MGR'],
            ['nama_jabatan' => 'Staff Admin', 'kode_jabatan' => 'ADM'],
            ['nama_jabatan' => 'Sales', 'kode_jabatan' => 'SLS'],
            ['nama_jabatan' => 'Marketing', 'kode_jabatan' => 'MKT'],
            ['nama_jabatan' => 'Customer Service', 'kode_jabatan' => 'CS'],
            ['nama_jabatan' => 'IT Support', 'kode_jabatan' => 'ITS'],
            ['nama_jabatan' => 'Accounting', 'kode_jabatan' => 'ACC'],
        ];

        foreach ($jabatan as $jbt) {
            Jabatan::create($jbt);
        }

        // Seed Lokasi Penempatan
        $lokasi = [
            [
                'nama_lokasi' => 'Kantor Pusat Jakarta',
                'alamat_lengkap' => 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta',
                'latitude' => -6.208763,
                'longitude' => 106.845599,
                'radius' => 100,
                'description' => 'Kantor pusat perusahaan di Jakarta'
            ],
            [
                'nama_lokasi' => 'Kantor Cabang Surabaya',
                'alamat_lengkap' => 'Jl. Pemuda No. 45, Surabaya, Jawa Timur',
                'latitude' => -7.257472,
                'longitude' => 112.752090,
                'radius' => 100,
                'description' => 'Kantor cabang di Surabaya'
            ],
            [
                'nama_lokasi' => 'Kantor Cabang Bandung',
                'alamat_lengkap' => 'Jl. Asia Afrika No. 67, Bandung, Jawa Barat',
                'latitude' => -6.914744,
                'longitude' => 107.609810,
                'radius' => 100,
                'description' => 'Kantor cabang di Bandung'
            ],
        ];

        foreach ($lokasi as $lok) {
            LokasiPenempatan::create($lok);
        }
    }
}
