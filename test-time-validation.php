<?php
// Test script untuk validasi waktu absensi
require_once 'vendor/autoload.php';

use Carbon\Carbon;

// Set timezone sesuai konfigurasi aplikasi
date_default_timezone_set('Asia/Jakarta'); // WIB

echo "=== TEST VALIDASI WAKTU ABSENSI ===\n\n";

// Simulasi berbagai waktu untuk testing
$testTimes = [
    '07:30:00', // Sebelum jam 8 - bisa absen masuk
    '08:00:00', // Tepat jam 8 - batas absen masuk
    '08:30:00', // Setelah jam 8 - tidak bisa absen masuk
    '12:00:00', // Siang hari
    '15:30:00', // Sebelum jam 4 sore - belum bisa absen keluar
    '16:00:00', // Tepat jam 4 sore - bisa absen keluar
    '17:30:00', // Setelah jam 4 sore - bisa absen keluar
];

foreach ($testTimes as $testTime) {
    echo "Waktu Test: $testTime\n";

    // Parse waktu test
    $currentTime = Carbon::today()->setTimeFromTimeString($testTime);
    $clockInDeadline = Carbon::today()->setTime(8, 0, 0); // 08:00:00
    $clockOutStartTime = Carbon::today()->setTime(16, 0, 0); // 16:00:00

    // Cek validasi absen masuk
    $canClockIn = $currentTime->lte($clockInDeadline);
    echo "  - Bisa absen masuk: " . ($canClockIn ? 'YA' : 'TIDAK') . "\n";

    if (!$canClockIn) {
        echo "    Alasan: Waktu absen masuk telah berakhir (max 08:00)\n";
    }

    // Cek validasi absen keluar
    $canClockOut = $currentTime->gte($clockOutStartTime);
    echo "  - Bisa absen keluar: " . ($canClockOut ? 'YA' : 'TIDAK') . "\n";

    if (!$canClockOut) {
        $remainingMinutes = $currentTime->diffInMinutes($clockOutStartTime);
        echo "    Alasan: Belum waktunya absen keluar (min 16:00), tersisa $remainingMinutes menit\n";
    }

    echo "\n";
}

echo "=== SIMULASI RESPON API ===\n\n";

// Simulasi respon seperti yang dikembalikan oleh getTodayStatus()
function simulateApiResponse($time)
{
    $currentTime = Carbon::today()->setTimeFromTimeString($time);
    $clockInDeadline = Carbon::today()->setTime(8, 0, 0);
    $clockOutStartTime = Carbon::today()->setTime(16, 0, 0);

    $timeStatus = [
        'current_time' => $currentTime->format('H:i:s'),
        'can_clock_in' => $currentTime->lte($clockInDeadline),
        'can_clock_out' => $currentTime->gte($clockOutStartTime),
        'clock_in_deadline' => $clockInDeadline->format('H:i:s'),
        'clock_out_start_time' => $clockOutStartTime->format('H:i:s'),
        'is_after_clock_in_deadline' => $currentTime->gt($clockInDeadline),
        'is_before_clock_out_time' => $currentTime->lt($clockOutStartTime),
    ];

    if ($currentTime->lte($clockInDeadline)) {
        $remainingMinutes = $currentTime->diffInMinutes($clockInDeadline);
        $timeStatus['time_message'] = "Waktu absen masuk tersisa " . $remainingMinutes . " menit";
    } elseif ($currentTime->lt($clockOutStartTime)) {
        $remainingMinutes = $currentTime->diffInMinutes($clockOutStartTime);
        $timeStatus['time_message'] = "Waktu absen keluar dalam " . $remainingMinutes . " menit";
    } else {
        $timeStatus['time_message'] = "Waktu absen keluar sudah dimulai";
    }

    return [
        'success' => true,
        'data' => [
            'has_clocked_in' => false,
            'has_clocked_out' => false,
            'jam_masuk' => null,
            'jam_keluar' => null,
            'lokasi_penempatan' => 'Test Office',
            'time_status' => $timeStatus
        ]
    ];
}

// Test beberapa waktu
$testCases = ['07:45:00', '08:15:00', '15:45:00', '16:15:00'];

foreach ($testCases as $time) {
    $response = simulateApiResponse($time);
    echo "Waktu: $time\n";
    echo "API Response:\n";
    echo json_encode($response, JSON_PRETTY_PRINT) . "\n\n";
}

echo "=== TEST SELESAI ===\n";
