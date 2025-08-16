# Dokumentasi Sistem Absensi dengan Validasi Lokasi

## Overview

Sistem absensi yang telah diimplementasikan memungkinkan karyawan untuk melakukan absensi masuk dan keluar dengan validasi lokasi menggunakan GPS browser. Sistem ini memastikan bahwa karyawan hanya dapat melakukan absensi ketika berada dalam radius yang ditentukan dari lokasi penempatan mereka.

## Fitur yang Diimplementasikan

### 1. **Controller AbsensiController**

-   **checkLocation()**: Memvalidasi apakah lokasi user berada dalam radius yang diizinkan
-   **clockIn()**: Melakukan absen masuk dengan validasi lokasi
-   **clockOut()**: Melakukan absen keluar dengan validasi lokasi
-   **getTodayStatus()**: Mendapatkan status absensi hari ini

### 2. **JavaScript Frontend Integration**

-   **Deteksi lokasi GPS browser** secara otomatis
-   **Validasi lokasi real-time** sebelum melakukan absensi
-   **UI feedback** dengan loading modal dan alert modal
-   **Status tracking** untuk menampilkan status absensi hari ini
-   **Button state management** berdasarkan status absensi

### 3. **Validasi Lokasi**

-   Menggunakan **formula Haversine** untuk menghitung jarak antara lokasi user dan lokasi penempatan
-   **Radius validation** berdasarkan setting lokasi penempatan
-   **Error handling** untuk berbagai kondisi error GPS

## Routes yang Ditambahkan

```php
Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::post('/check-location', [AbsensiController::class, 'checkLocation'])->name('check-location');
    Route::post('/clock-in', [AbsensiController::class, 'clockIn'])->name('clock-in');
    Route::post('/clock-out', [AbsensiController::class, 'clockOut'])->name('clock-out');
    Route::get('/status', [AbsensiController::class, 'getTodayStatus'])->name('status');
});
```

## Cara Kerja Sistem

### 1. **Inisialisasi Halaman**

-   Saat halaman dimuat, sistem meminta izin akses lokasi dari browser
-   Sistem mengecek status absensi hari ini
-   Button states diupdate berdasarkan status absensi

### 2. **Proses Absen Masuk**

1. User menekan tombol "Absen Masuk"
2. Sistem mengecek apakah GPS tersedia
3. Sistem memvalidasi lokasi user dengan endpoint `/absensi/check-location`
4. Jika lokasi valid, sistem melakukan absen masuk dengan endpoint `/absensi/clock-in`
5. Sistem menampilkan feedback kepada user
6. Status dan button states diupdate

### 3. **Proses Absen Keluar**

1. User menekan tombol "Absen Keluar"
2. Sistem mengecek apakah user sudah absen masuk
3. Sistem memvalidasi lokasi user
4. Jika valid, sistem melakukan absen keluar dengan endpoint `/absensi/clock-out`
5. Sistem menampilkan feedback kepada user

## Validasi dan Error Handling

### **Validasi Lokasi**

-   User harus berada dalam radius yang ditentukan dari lokasi penempatan
-   Jika di luar radius, sistem menampilkan jarak aktual vs maksimal yang diizinkan

### **Validasi Absensi**

-   User tidak bisa absen masuk dua kali dalam sehari
-   User tidak bisa absen keluar tanpa absen masuk terlebih dahulu
-   User tidak bisa absen keluar dua kali dalam sehari

### **Error Handling GPS**

-   Permission denied: User diminta untuk mengizinkan akses lokasi
-   Position unavailable: Informasi lokasi tidak tersedia
-   Timeout: Timeout saat mendapatkan lokasi

## Security Features

1. **CSRF Protection**: Semua request AJAX menggunakan CSRF token
2. **Authentication**: Hanya user yang login yang bisa mengakses
3. **Location Validation**: Validasi jarak menggunakan server-side calculation
4. **Database Logging**: Semua aktivitas absensi tersimpan dengan koordinat lokasi

## Data yang Disimpan

Setiap record absensi menyimpan:

-   `user_id`: ID user yang melakukan absensi
-   `tanggal`: Tanggal absensi
-   `jam_masuk` & `jam_keluar`: Waktu absen masuk dan keluar
-   `lokasi_masuk` & `lokasi_keluar`: Nama lokasi penempatan
-   `latitude_masuk` & `longitude_masuk`: Koordinat GPS saat absen masuk
-   `latitude_keluar` & `longitude_keluar`: Koordinat GPS saat absen keluar

## Testing & Development

### **Data Lokasi Test**

Sistem sudah dilengkapi dengan seeder yang berisi 5 lokasi stasiun kereta api:

-   Stasiun Doplang (radius 200m)
-   Stasiun Wadu (radius 200m)
-   Stasiun Randublatung (radius 200m)
-   Stasiun Kradenan (radius 200m)
-   Stasiun Sulur (radius 200m)

### **Menjalankan Server**

```bash
php artisan serve
```

### **Menjalankan Seeder**

```bash
php artisan db:seed --class=LokasiPenempatanSeeder
```

## User Experience

### **Visual Feedback**

-   Loading spinner saat memproses lokasi
-   Alert modal dengan icon sesuai status (success/error/info)
-   Real-time status update
-   Button disabled states untuk mencegah double submission

### **Status Indicator**

-   🟢 Hijau: Siap untuk absensi
-   🟠 Orange: Sedang bekerja (sudah absen masuk)
-   🔵 Biru: Hari kerja selesai (sudah absen keluar)
-   🟡 Kuning: Memuat status
-   🔴 Merah: Error GPS/lokasi

## Next Steps

Fitur-fitur yang bisa ditambahkan selanjutnya:

1. **Photo capture** saat absensi
2. **Offline mode** untuk area dengan koneksi terbatas
3. **Geofencing** dengan multiple points
4. **Admin dashboard** untuk monitoring real-time
5. **Report generation** untuk analisis kehadiran
6. **Push notifications** untuk reminder absensi
