<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LokasiPenempatan;

class LokasiPenempatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'nama_lokasi' => 'Stasiun Doplang',
                'alamat_lengkap' => 'Dukuhan, Doplang, Jati, Blora Regency, Central Java 58384',
                'latitude' => -7.18290000,
                'longitude' => 111.28796000,
                'radius' => 200,
                'description' => 'Stasiun kereta api yang terletak di wilayah Doplang, Jati, Kabupaten Blora'
            ],
            [
                'nama_lokasi' => 'Stasiun Wadu',
                'alamat_lengkap' => 'Wado Wetan, Wado, Kedungtuban, Blora Regency, Central Java 58381',
                'latitude' => -7.196346812562705,
                'longitude' => 111.50045021078911,
                'radius' => 200,
                'description' => 'Stasiun kereta api yang terletak di wilayah Wado, Kedungtuban, Kabupaten Blora'
            ],
            [
                'nama_lokasi' => 'Stasiun Randublatung',
                'alamat_lengkap' => 'Wulung, Randublatung, Blora Regency, Central Java 58382',
                'latitude' => -7.1923046694479185,
                'longitude' => 111.39802865889547,
                'radius' => 200,
                'description' => 'Stasiun kereta api yang terletak di wilayah Randublatung, Kabupaten Blora'
            ],
            [
                'nama_lokasi' => 'Stasiun Kradenan',
                'alamat_lengkap' => 'Wates, Kradenan, Grobogan Regency, Central Java 58182',
                'latitude' => -7.150215037729748,
                'longitude' => 111.14688608616743,
                'radius' => 200,
                'description' => 'Stasiun kereta api yang terletak di wilayah Kradenan, Kabupaten Grobogan'
            ],
            [
                'nama_lokasi' => 'Stasiun Sulur',
                'alamat_lengkap' => 'Jl. Raya Tahunan No.14, Brumbung, Tahunan, Kecamatan Gabus, Kabupaten Grobogan, Jawa Tengah 58183',
                'latitude' => -7.174107942875657,
                'longitude' => 111.22276778834343,
                'radius' => 200,
                'description' => 'Stasiun kereta api yang terletak di wilayah Gabus, Kabupaten Grobogan'
            ]
        ];

        // Only add locations if they don't exist (check by nama_lokasi)
        foreach ($locations as $location) {
            LokasiPenempatan::firstOrCreate(
                ['nama_lokasi' => $location['nama_lokasi']], // Check condition
                $location // Data to insert if not found
            );
        }

        // Output message
        $this->command->info('Successfully seeded ' . count($locations) . ' lokasi penempatan (train stations).');
    }
}
