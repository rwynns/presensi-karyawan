<?php

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LokasiPenempatan;

// Require Laravel bootstrap
require_once 'bootstrap/app.php';
$app = new \Illuminate\Foundation\Application();

echo "Creating test user...\n";

// Get first location for assignment
$lokasi = LokasiPenempatan::first();

if (!$lokasi) {
    echo "No location found! Please run the LokasiPenempatanSeeder first.\n";
    exit(1);
}

// Create or update test user
$user = User::updateOrCreate(
    ['email' => 'test@example.com'],
    [
        'nama' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'role_id' => 2, // Karyawan
        'lokasi_id' => $lokasi->id,
        'jabatan_id' => 1,
        'is_active' => true
    ]
);

echo "Test user created/updated:\n";
echo "Email: test@example.com\n";
echo "Password: password123\n";
echo "Assigned Location: {$lokasi->nama_lokasi}\n";
echo "Location coordinates: {$lokasi->latitude}, {$lokasi->longitude}\n";
echo "Radius: {$lokasi->radius}m\n";

echo "\nYou can now login and test the attendance system.\n";
