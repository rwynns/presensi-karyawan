<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = App\Models\User::find(6);
if ($user) {
    echo "User 6: " . $user->nama . PHP_EOL;
    echo "Email: " . $user->email . PHP_EOL;
    echo "Role ID: " . $user->role_id . PHP_EOL;
    echo "Lokasi ID: " . $user->lokasi_id . PHP_EOL;

    if ($user->lokasiPenempatan) {
        echo "Lokasi Penempatan: " . $user->lokasiPenempatan->nama_lokasi . PHP_EOL;
        echo "Koordinat: " . $user->lokasiPenempatan->latitude . ", " . $user->lokasiPenempatan->longitude . PHP_EOL;
        echo "Radius: " . $user->lokasiPenempatan->radius . " meter" . PHP_EOL;
    } else {
        echo "Tidak ada lokasi penempatan" . PHP_EOL;
    }
} else {
    echo "User 6 tidak ditemukan" . PHP_EOL;
}

echo PHP_EOL . "Total lokasi penempatan: " . App\Models\LokasiPenempatan::count() . PHP_EOL;
