<?php

// Script untuk membuat foto sample placeholder
// Jalankan dengan: php create-sample-photos.php

$storageDir = __DIR__ . '/storage/app/public/absensi';

// Pastikan direktori ada
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

// Buat 5 foto placeholder sederhana
for ($i = 1; $i <= 5; $i++) {
    $filename = "sample-foto-{$i}.jpg";
    $filepath = $storageDir . '/' . $filename;

    // Buat image placeholder 300x300
    $image = imagecreate(300, 300);

    // Warna background
    $bg_color = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
    $text_color = imagecolorallocate($image, 255, 255, 255);

    // Fill background
    imagefill($image, 0, 0, $bg_color);

    // Tambahkan teks
    $text = "Sample Photo {$i}";
    imagestring($image, 5, 80, 140, $text, $text_color);

    // Save sebagai JPEG
    imagejpeg($image, $filepath, 80);
    imagedestroy($image);

    echo "Created: {$filename}\n";
}

echo "All sample photos created successfully!\n";
