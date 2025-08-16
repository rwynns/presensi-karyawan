# Quick Debug Guide - Masalah Lokasi Absensi

## Langkah Debugging:

### 1. Login ke sistem

-   Email: `test@example.com`
-   Password: `password123`

### 2. Klik tombol "Debug GPS" (tombol orange)

Tombol ini akan:

-   Mengambil lokasi GPS browser yang sebenarnya
-   Menampilkan koordinat detail
-   Menghitung jarak ke lokasi kantor
-   Menampilkan link Google Maps untuk verifikasi

### 3. Analisis hasil debug

Perhatikan informasi yang muncul:

-   **Your Location**: Koordinat GPS browser Anda
-   **Office Location**: Koordinat lokasi penempatan dari database
-   **Distance**: Jarak yang dihitung
-   **Status**: Apakah valid atau terlalu jauh

### 4. Bandingkan dengan Google Maps

-   Klik link "Your Location" untuk melihat posisi GPS browser
-   Klik link "Office Location" untuk melihat posisi kantor dari database
-   Bandingkan apakah posisi benar-benar sama

## Kemungkinan Penyebab Masalah:

1. **GPS Browser tidak akurat** (accuracy > 100m)
2. **Koordinat database salah** (tidak sesuai lokasi fisik)
3. **Radius terlalu kecil** (200m mungkin kurang)

## Solusi Berdasarkan Hasil Debug:

### Jika GPS tidak akurat:

-   Gunakan tombol "Test Lokasi" (abu-abu) untuk simulasi
-   Refresh browser dan coba lagi
-   Pindah ke area dengan sinyal GPS lebih baik

### Jika koordinat database salah:

-   Update koordinat di database sesuai lokasi fisik
-   Gunakan Google Maps untuk mendapatkan koordinat yang tepat

### Jika radius terlalu kecil:

-   Increase radius di database (misalnya 500m atau 1000m)

## Console Browser (F12)

Lihat console untuk:

-   Detail lengkap koordinat
-   Link Google Maps yang bisa diklik
-   Error messages jika ada

Setelah debug, bagikan screenshot hasil atau copy-paste info debug ke chat untuk analisis lebih lanjut.
