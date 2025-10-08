<?php

/**
 * Script untuk testing fitur Izin Masuk Terlambat dan Pulang Awal
 * Jalankan: php test-time-permissions.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Izin;
use App\Models\Absensi;
use Carbon\Carbon;

echo "=== TESTING FITUR IZIN WAKTU KHUSUS ===\n\n";

// 1. Test User dengan Izin Terlambat
echo "1. Testing Izin Masuk Terlambat...\n";
$user = User::where('role_id', '!=', 1)->first(); // Ambil user non-admin

if ($user) {
    // Buat izin masuk terlambat hari ini
    $izinTerlambat = Izin::create([
        'user_id' => $user->id,
        'jenis_izin' => 'izin_masuk_terlambat',
        'tanggal_mulai' => Carbon::today(),
        'tanggal_selesai' => Carbon::today(),
        'jam_masuk_maksimal' => '09:30:00',
        'is_hari_ini' => true,
        'alasan' => 'Test izin masuk terlambat',
        'keterangan' => 'Test izin masuk terlambat untuk testing fitur',
        'status' => 'disetujui'
    ]);

    echo "   ✓ Izin terlambat dibuat: ID {$izinTerlambat->id}\n";

    // Test method model
    $hasLatePermission = Izin::hasLateArrivalPermissionToday($user->id);
    echo "   ✓ hasLateArrivalPermissionToday(): " . ($hasLatePermission ? 'TRUE' : 'FALSE') . "\n";

    $timePermission = Izin::getTodayTimePermission($user->id, 'izin_masuk_terlambat');
    if ($timePermission) {
        echo "   ✓ getTodayTimePermission(): {$timePermission->jenis_izin}\n";
        echo "   ✓ Jam masuk maksimal: {$timePermission->jam_masuk_maksimal}\n";
    }
}

echo "\n";

// 2. Test User dengan Izin Pulang Awal
echo "2. Testing Izin Pulang Awal...\n";
$user2 = User::where('role_id', '!=', 1)->skip(1)->first();

if ($user2) {
    // Buat izin pulang awal hari ini
    $izinPulangAwal = Izin::create([
        'user_id' => $user2->id,
        'jenis_izin' => 'izin_pulang_awal',
        'tanggal_mulai' => Carbon::today(),
        'tanggal_selesai' => Carbon::today(),
        'jam_pulang_awal' => '15:00:00',
        'is_hari_ini' => true,
        'alasan' => 'Test izin pulang awal',
        'keterangan' => 'Test izin pulang awal untuk testing fitur',
        'status' => 'disetujui'
    ]);

    echo "   ✓ Izin pulang awal dibuat: ID {$izinPulangAwal->id}\n";

    // Test method model
    $hasEarlyPermission = Izin::hasEarlyDeparturePermissionToday($user2->id);
    echo "   ✓ hasEarlyDeparturePermissionToday(): " . ($hasEarlyPermission ? 'TRUE' : 'FALSE') . "\n";

    $timePermission2 = Izin::getTodayTimePermission($user2->id, 'izin_pulang_awal');
    if ($timePermission2) {
        echo "   ✓ getTodayTimePermission(): {$timePermission2->jenis_izin}\n";
        echo "   ✓ Jam pulang awal: {$timePermission2->jam_pulang_awal}\n";
    }
}

echo "\n";

// 3. Test Validasi Waktu
echo "3. Testing Validasi Waktu...\n";

// Simulasi waktu berbeda
$testTimes = [
    '07:30:00' => 'Sebelum jam kerja',
    '08:30:00' => 'Setelah jam masuk normal',
    '09:15:00' => 'Dalam batas izin terlambat',
    '10:00:00' => 'Melewati batas izin terlambat',
    '15:30:00' => 'Dalam waktu izin pulang awal',
    '16:30:00' => 'Setelah jam kerja normal'
];

foreach ($testTimes as $time => $desc) {
    echo "   Testing waktu {$time} ({$desc}):\n";

    $carbonTime = Carbon::createFromFormat('H:i:s', $time);
    $workStart = Carbon::createFromFormat('H:i:s', '08:00:00');
    $workEnd = Carbon::createFromFormat('H:i:s', '16:00:00');

    // Logic validasi dasar
    $canClockInNormal = $carbonTime->lte($workStart);
    $canClockOutNormal = $carbonTime->gte($workEnd);

    echo "     - Clock in normal: " . ($canClockInNormal ? 'YA' : 'TIDAK') . "\n";
    echo "     - Clock out normal: " . ($canClockOutNormal ? 'YA' : 'TIDAK') . "\n";

    // Test dengan izin terlambat (09:30)
    if (isset($izinTerlambat)) {
        $lateLimit = Carbon::parse($izinTerlambat->jam_masuk_maksimal);
        $canClockInWithPermission = $carbonTime->lte($lateLimit);
        echo "     - Clock in dengan izin terlambat: " . ($canClockInWithPermission ? 'YA' : 'TIDAK') . "\n";
    }

    // Test dengan izin pulang awal (15:00)
    if (isset($izinPulangAwal)) {
        $earlyLimit = Carbon::parse($izinPulangAwal->jam_pulang_awal);
        $canClockOutEarly = $carbonTime->gte($earlyLimit);
        echo "     - Clock out dengan izin pulang awal: " . ($canClockOutEarly ? 'YA' : 'TIDAK') . "\n";
    }

    echo "\n";
}

// 4. Test Database Query
echo "4. Testing Database Queries...\n";

// Cek izin hari ini
$todayPermissions = Izin::whereDate('tanggal_mulai', Carbon::today())
    ->where('is_hari_ini', true)
    ->where('status', 'disetujui')
    ->whereIn('jenis_izin', ['izin_masuk_terlambat', 'izin_pulang_awal'])
    ->get();

echo "   ✓ Total izin waktu khusus hari ini: {$todayPermissions->count()}\n";

foreach ($todayPermissions as $permission) {
    echo "   - User: {$permission->user->name}, Jenis: {$permission->jenis_izin}\n";
    if ($permission->jam_masuk_maksimal) {
        echo "     Jam masuk maksimal: {$permission->jam_masuk_maksimal}\n";
    }
    if ($permission->jam_pulang_awal) {
        echo "     Jam pulang awal: {$permission->jam_pulang_awal}\n";
    }
}

echo "\n";

// 5. Test Helper Methods
echo "5. Testing Model Helper Methods...\n";

$testIzin = $todayPermissions->first();
if ($testIzin) {
    echo "   ✓ isTimeBasedPermission(): " . ($testIzin->isTimeBasedPermission() ? 'TRUE' : 'FALSE') . "\n";

    // Test static method getTodayTimePermission
    $todayTimePermission = Izin::getTodayTimePermission($testIzin->user_id, $testIzin->jenis_izin);
    echo "   ✓ getTodayTimePermission static method: " . ($todayTimePermission ? 'FOUND' : 'NOT FOUND') . "\n";
}

echo "\n=== CLEANUP ===\n";

// Cleanup test data
if (isset($izinTerlambat)) {
    $izinTerlambat->delete();
    echo "✓ Izin terlambat test dihapus\n";
}

if (isset($izinPulangAwal)) {
    $izinPulangAwal->delete();
    echo "✓ Izin pulang awal test dihapus\n";
}

echo "\n=== TESTING SELESAI ===\n";
echo "Semua fitur izin waktu khusus telah ditest!\n";
echo "Silakan test manual melalui browser untuk UI testing.\n";
