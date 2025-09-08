<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Jabatan;
use App\Models\LokasiPenempatan;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class KaryawanAbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role karyawan ada
        $karyawanRole = Role::firstOrCreate(['nama_role' => 'karyawan']);

        // Buat jabatan jika belum ada
        $jabatan1 = Jabatan::firstOrCreate([
            'kode_jabatan' => 'IT001'
        ], [
            'nama_jabatan' => 'Staff IT'
        ]);

        $jabatan2 = Jabatan::firstOrCreate([
            'kode_jabatan' => 'MKT001'
        ], [
            'nama_jabatan' => 'Staff Marketing'
        ]);

        $jabatan3 = Jabatan::firstOrCreate([
            'kode_jabatan' => 'FIN001'
        ], [
            'nama_jabatan' => 'Staff Finance'
        ]);

        // Buat lokasi penempatan jika belum ada
        $lokasi1 = LokasiPenempatan::firstOrCreate([
            'nama_lokasi' => 'Kantor Pusat Jakarta'
        ], [
            'alamat_lengkap' => 'Jl. Sudirman No. 123, Jakarta',
            'latitude' => -6.1944901,
            'longitude' => 106.8229198,
            'radius' => 100,
            'jam_masuk' => '08:00:00',
            'jam_pulang' => '17:00:00'
        ]);

        $lokasi2 = LokasiPenempatan::firstOrCreate([
            'nama_lokasi' => 'Kantor Cabang Surabaya'
        ], [
            'alamat_lengkap' => 'Jl. Pemuda No. 456, Surabaya',
            'latitude' => -7.2574719,
            'longitude' => 112.7520883,
            'radius' => 150,
            'jam_masuk' => '07:30:00',
            'jam_pulang' => '16:30:00'
        ]);

        $lokasi3 = LokasiPenempatan::firstOrCreate([
            'nama_lokasi' => 'Remote Office'
        ], [
            'alamat_lengkap' => 'Work From Home',
            'latitude' => -6.2087634,
            'longitude' => 106.845599,
            'radius' => 50,
            'jam_masuk' => '09:00:00',
            'jam_pulang' => '18:00:00'
        ]);

        // Data karyawan untuk testing
        $karyawanData = [
            [
                'nama' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@company.com',
                'jabatan_id' => $jabatan1->id,
                'lokasi_id' => $lokasi1->id,
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@company.com',
                'jabatan_id' => $jabatan2->id,
                'lokasi_id' => $lokasi1->id,
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@company.com',
                'jabatan_id' => $jabatan3->id,
                'lokasi_id' => $lokasi2->id,
            ],
            [
                'nama' => 'Maya Sari',
                'email' => 'maya.sari@company.com',
                'jabatan_id' => $jabatan1->id,
                'lokasi_id' => $lokasi2->id,
            ],
            [
                'nama' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@company.com',
                'jabatan_id' => $jabatan2->id,
                'lokasi_id' => $lokasi3->id,
            ]
        ];

        $karyawan = [];

        // Buat karyawan
        foreach ($karyawanData as $data) {
            $user = User::updateOrCreate([
                'email' => $data['email']
            ], [
                'nama' => $data['nama'],
                'password' => Hash::make('password123'),
                'role_id' => $karyawanRole->id,
                'jabatan_id' => $data['jabatan_id'],
                'lokasi_id' => $data['lokasi_id'],
            ]);

            $karyawan[] = $user;
        }

        // Buat data absensi untuk 30 hari terakhir
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now()->subDay(); // Sampai kemarin

        foreach ($karyawan as $user) {
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                // Skip weekend (Saturday = 6, Sunday = 0)
                if ($currentDate->dayOfWeek == 0 || $currentDate->dayOfWeek == 6) {
                    $currentDate->addDay();
                    continue;
                }

                // 90% kemungkinan masuk kerja
                if (rand(1, 100) <= 90) {
                    $this->createAbsensiRecord($user, $currentDate->copy());
                }

                $currentDate->addDay();
            }
        }

        $this->command->info('Berhasil membuat ' . count($karyawan) . ' karyawan dan data absensi mereka.');
        $this->command->info('Login credentials:');
        foreach ($karyawan as $user) {
            $this->command->info("- {$user->email} / password123");
        }
    }

    private function createAbsensiRecord(User $user, Carbon $date)
    {
        $lokasi = $user->lokasiPenempatan;
        if (!$lokasi) return;

        // Parse jam masuk lokasi
        $jamMasukLokasi = Carbon::parse($lokasi->jam_masuk);
        $jamPulangLokasi = Carbon::parse($lokasi->jam_pulang);

        // Variasi kedatangan: 
        // 70% tepat waktu atau lebih awal
        // 30% terlambat (5-60 menit)
        $isLate = rand(1, 100) <= 30;

        if ($isLate) {
            // Terlambat 5-60 menit
            $lateMinutes = rand(5, 60);
            $jamMasuk = $jamMasukLokasi->copy()->addMinutes($lateMinutes);
        } else {
            // Tepat waktu atau lebih awal (0-15 menit lebih awal)
            $earlyMinutes = rand(0, 15);
            $jamMasuk = $jamMasukLokasi->copy()->subMinutes($earlyMinutes);
        }

        // Jam keluar: 80% pulang normal, 20% pulang lebih awal/lembur
        $pulangVariasi = rand(1, 100);
        if ($pulangVariasi <= 60) {
            // Pulang normal (±30 menit)
            $jamKeluar = $jamPulangLokasi->copy()->addMinutes(rand(-30, 30));
        } elseif ($pulangVariasi <= 80) {
            // Pulang lebih awal
            $jamKeluar = $jamPulangLokasi->copy()->subMinutes(rand(30, 120));
        } else {
            // Lembur
            $jamKeluar = $jamPulangLokasi->copy()->addMinutes(rand(60, 180));
        }

        // Set tanggal yang benar
        $jamMasuk->setDate($date->year, $date->month, $date->day);
        $jamKeluar->setDate($date->year, $date->month, $date->day);

        // Buat record absensi
        Absensi::updateOrCreate([
            'user_id' => $user->id,
            'tanggal' => $date->toDateString(),
        ], [
            'lokasi_penempatan_id' => $lokasi->id,
            'jam_masuk' => $jamMasuk,
            'jam_keluar' => $jamKeluar,
            'latitude_masuk' => $lokasi->latitude + (rand(-10, 10) / 100000), // Variasi kecil
            'longitude_masuk' => $lokasi->longitude + (rand(-10, 10) / 100000),
            'latitude_keluar' => $lokasi->latitude + (rand(-10, 10) / 100000),
            'longitude_keluar' => $lokasi->longitude + (rand(-10, 10) / 100000),
            'jarak_masuk' => rand(5, 50), // 5-50 meter dari lokasi
            'jarak_keluar' => rand(5, 50),
            'foto_masuk' => 'absensi/sample-foto-' . rand(1, 5) . '.jpg',
            'foto_keluar' => 'absensi/sample-foto-' . rand(1, 5) . '.jpg',
            'status' => 'keluar',
            'keterangan' => null
        ]);
    }
}
