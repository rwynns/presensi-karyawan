<?php

/**
 * Script untuk testing format waktu di status display
 * Jalankan: php test-time-display.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Izin;
use Carbon\Carbon;

echo "=== TESTING FORMAT WAKTU STATUS DISPLAY ===\n\n";

// Buat test izin terlambat
$user = User::where('role_id', '!=', 1)->first();

if ($user) {
    // Buat izin masuk terlambat
    $izinTerlambat = Izin::create([
        'user_id' => $user->id,
        'jenis_izin' => 'izin_masuk_terlambat',
        'tanggal_mulai' => Carbon::today(),
        'tanggal_selesai' => Carbon::today(),
        'jam_masuk_maksimal' => '09:30:00',
        'is_hari_ini' => true,
        'alasan' => 'Test format waktu',
        'keterangan' => 'Test format waktu untuk display',
        'status' => 'disetujui'
    ]);

    echo "✓ Test izin terlambat dibuat\n";
    echo "  - jam_masuk_maksimal dari database: {$izinTerlambat->jam_masuk_maksimal}\n";
    echo "  - Format substr(0,5): " . substr($izinTerlambat->jam_masuk_maksimal, 0, 5) . "\n";

    // Buat izin pulang awal
    $izinPulangAwal = Izin::create([
        'user_id' => $user->id,
        'jenis_izin' => 'izin_pulang_awal',
        'tanggal_mulai' => Carbon::today(),
        'tanggal_selesai' => Carbon::today(),
        'jam_pulang_awal' => '15:30:00',
        'is_hari_ini' => true,
        'alasan' => 'Test format waktu',
        'keterangan' => 'Test format waktu untuk display',
        'status' => 'disetujui'
    ]);

    echo "\n✓ Test izin pulang awal dibuat\n";
    echo "  - jam_pulang_awal dari database: {$izinPulangAwal->jam_pulang_awal}\n";
    echo "  - Format substr(0,5): " . substr($izinPulangAwal->jam_pulang_awal, 0, 5) . "\n";

    echo "\n=== TESTING API RESPONSE ===\n";

    // Simulate API call untuk getTodayStatus
    // Note: Kita tidak bisa langsung call method karena butuh Auth::user()
    echo "Untuk test full API response, silakan:\n";
    echo "1. Login ke http://127.0.0.1:8000\n";
    echo "2. Buka browser developer tools (F12)\n";
    echo "3. Lihat Network tab, response dari /absensi/status\n";
    echo "4. Periksa format waktu di special_permissions\n\n";

    // Cleanup
    $izinTerlambat->delete();
    $izinPulangAwal->delete();

    echo "✓ Test data cleaned up\n";
}

echo "\n=== TESTING SELESAI ===\n";
echo "Format waktu sekarang sudah diperbaiki menggunakan substr(0,5)\n";
echo "Silakan refresh browser untuk melihat perbaikan!\n";
