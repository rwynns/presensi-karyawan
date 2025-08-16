<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

// Set up Laravel environment
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\LokasiPenempatan;

echo "=== Testing User and Location Relationship ===\n\n";

// Get test user
$user = User::where('email', 'test@example.com')->first();

if (!$user) {
    echo "Test user not found!\n";
    exit(1);
}

echo "User ID: {$user->id}\n";
echo "User Name: {$user->nama}\n";
echo "User lokasi_id: {$user->lokasi_id}\n";

// Check if lokasi_id is set
if ($user->lokasi_id) {
    echo "Checking location relationship...\n";

    $lokasi = $user->lokasiPenempatan;

    if ($lokasi) {
        echo "✓ Location found:\n";
        echo "  - ID: {$lokasi->id}\n";
        echo "  - Name: {$lokasi->nama_lokasi}\n";
        echo "  - Latitude: {$lokasi->latitude}\n";
        echo "  - Longitude: {$lokasi->longitude}\n";
        echo "  - Radius: {$lokasi->radius}\n";
    } else {
        echo "✗ Location relationship failed!\n";

        // Try direct query
        $directLokasi = LokasiPenempatan::find($user->lokasi_id);
        if ($directLokasi) {
            echo "Direct query works: {$directLokasi->nama_lokasi}\n";
        } else {
            echo "Location ID {$user->lokasi_id} not found in database!\n";
        }
    }
} else {
    echo "User has no lokasi_id assigned!\n";
}

echo "\n=== All Locations ===\n";
$allLocations = LokasiPenempatan::all();
foreach ($allLocations as $loc) {
    echo "ID: {$loc->id} - {$loc->nama_lokasi}\n";
}

echo "\n=== Test Complete ===\n";
