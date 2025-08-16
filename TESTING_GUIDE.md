# Panduan Testing Sistem Absensi

## Persiapan Testing

### 1. User Test

Telah dibuat user test dengan kredensial:

-   **Email**: test@example.com
-   **Password**: password123
-   **Lokasi Penempatan**: Stasiun Doplang
-   **Koordinat**: -7.18290000, 111.28796000
-   **Radius**: 200 meter

### 2. Langkah-langkah Testing

#### A. Login ke Sistem

1. Buka browser ke `http://127.0.0.1:8000/login`
2. Login dengan kredensial di atas
3. Setelah login akan redirect ke halaman dashboard absensi

#### B. Testing Validasi Lokasi

**Cara 1: Menggunakan GPS Browser**

1. Pastikan browser mengizinkan akses lokasi
2. Sistem akan otomatis detect lokasi Anda
3. Jika lokasi Anda tidak dalam radius 200m dari Stasiun Doplang, akan muncul error

**Cara 2: Menggunakan Fitur Test Lokasi (Recommended)**

1. Klik tombol "Test Lokasi" di bagian bawah
2. Ini akan set lokasi ke koordinat Stasiun Doplang secara manual
3. Status akan berubah menjadi "Test lokasi: Stasiun Doplang"

#### C. Testing Absen Masuk

1. Setelah lokasi valid (menggunakan cara 1 atau 2)
2. Klik tombol "Absen Masuk"
3. Sistem akan:
    - Validasi lokasi lagi
    - Jika valid, catat waktu masuk
    - Update status dan disable tombol absen masuk
    - Enable tombol absen keluar

#### D. Testing Absen Keluar

1. Setelah berhasil absen masuk
2. Klik tombol "Absen Keluar"
3. Sistem akan:
    - Validasi lokasi lagi
    - Jika valid, catat waktu keluar
    - Update status menjadi "Hari kerja selesai"
    - Disable kedua tombol

## Debugging Features

### 1. Console Logs

Buka Developer Tools (F12) untuk melihat:

-   Response dari server untuk check location
-   Debug info termasuk koordinat dan jarak
-   Error messages jika ada

### 2. Debug Info dalam Response

Sistem akan menampilkan informasi detail termasuk:

-   Koordinat user vs koordinat kantor
-   Jarak aktual vs radius maksimal
-   Lokasi penempatan user

### 3. Debug Route

Akses `http://127.0.0.1:8000/debug-user` untuk melihat:

-   Data user lengkap
-   Informasi lokasi penempatan
-   Semua lokasi yang tersedia

## Troubleshooting

### Masalah Umum:

1. **"Anda belum memiliki lokasi penempatan"**

    - Pastikan user memiliki lokasi_id yang valid
    - Cek dengan debug route

2. **"Lokasi terlalu jauh"**

    - Gunakan fitur "Test Lokasi" untuk set koordinat manual
    - Periksa koordinat di console log
    - Pastikan radius cukup besar (default 200m)

3. **GPS Error**

    - Izinkan akses lokasi di browser
    - Refresh halaman jika perlu
    - Gunakan fitur test lokasi sebagai alternatif

4. **Button tidak berfungsi**
    - Periksa console untuk JavaScript errors
    - Pastikan CSRF token tersedia
    - Refresh halaman

## Data Testing Tambahan

Jika ingin test dengan lokasi lain, tersedia 5 stasiun:

1. Stasiun Doplang: -7.18290000, 111.28796000
2. Stasiun Wadu: -7.196346812562705, 111.50045021078911
3. Stasiun Randublatung: -7.1923046694479185, 111.39802865889547
4. Stasiun Kradenan: -7.150215037729748, 111.14688608616743
5. Stasiun Sulur: -7.174107942875657, 111.22276778834343

Untuk mengubah lokasi penempatan user, jalankan:

```php
php artisan tinker
User::find(7)->update(['lokasi_id' => 2]); // Ganti ke Stasiun Wadu
```

## Expected Behavior

### Skenario Success:

1. User login ✓
2. Lokasi detected/set ✓
3. Absen masuk berhasil ✓
4. Status berubah ke "Sedang bekerja" ✓
5. Absen keluar berhasil ✓
6. Status berubah ke "Hari kerja selesai" ✓

### Validasi yang Harus Berfungsi:

-   ✓ Tidak bisa absen masuk 2x dalam sehari
-   ✓ Tidak bisa absen keluar tanpa absen masuk
-   ✓ Tidak bisa absen keluar 2x dalam sehari
-   ✓ Validasi jarak lokasi
-   ✓ Handle GPS errors gracefully

Jika ada masalah, periksa console browser dan server logs untuk detail error.
