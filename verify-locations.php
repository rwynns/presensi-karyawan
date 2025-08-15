<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\LokasiPenempatan;

echo "=== LOKASI PENEMPATAN SEEDER VERIFICATION ===\n";
echo "Total locations in database: " . LokasiPenempatan::count() . "\n\n";

echo "List of all locations:\n";
$locations = LokasiPenempatan::all();
foreach ($locations as $index => $location) {
    echo ($index + 1) . ". " . $location->nama_lokasi . "\n";
    echo "   Address: " . $location->alamat_lengkap . "\n";
    echo "   Coordinates: " . $location->latitude . ", " . $location->longitude . "\n";
    echo "   Radius: " . $location->radius . " meter\n";
    echo "   Description: " . ($location->description ?? 'N/A') . "\n\n";
}

echo "=== VERIFICATION COMPLETE ===\n";
