<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            [
                'kode_jabatan' => 'DIR',
                'nama_jabatan' => 'Direktur',
            ],
            [
                'kode_jabatan' => 'MGR',
                'nama_jabatan' => 'Manager',
            ],
            [
                'kode_jabatan' => 'SPV',
                'nama_jabatan' => 'Supervisor',
            ],
            [
                'kode_jabatan' => 'STF',
                'nama_jabatan' => 'Staff',
            ],
            [
                'kode_jabatan' => 'TEK',
                'nama_jabatan' => 'Teknisi',
            ],
            [
                'kode_jabatan' => 'SEC',
                'nama_jabatan' => 'Security',
            ],
        ];

        foreach ($jabatan as $item) {
            Jabatan::firstOrCreate(
                ['kode_jabatan' => $item['kode_jabatan']],
                $item
            );
        }
    }
}
