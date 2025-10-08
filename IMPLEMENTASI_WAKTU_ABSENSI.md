# IMPLEMENTASI SISTEM WAKTU ABSENSI

## Deskripsi

Sistem pembatasan waktu absensi yang telah diimplementasikan:

-   **Absen Masuk**: Hanya diperbolehkan sebelum jam 08:00 WIB
-   **Absen Keluar**: Hanya diperbolehkan setelah jam 16:00 WIB

## Fitur yang Diimplementasikan

### Backend (AbsensiController.php)

1. **Validasi Waktu pada Clock In**

    - Mengecek apakah waktu saat ini <= 08:00:00
    - Mengembalikan error message jika sudah lewat jam 8 pagi

2. **Validasi Waktu pada Clock Out**

    - Mengecek apakah waktu saat ini >= 16:00:00
    - Mengembalikan error message jika belum jam 4 sore

3. **Method getTodayStatus() yang Diperluas**
    - Menambahkan informasi `time_status` dengan detail:
        - `current_time`: Waktu saat ini
        - `can_clock_in`: Boolean apakah bisa absen masuk
        - `can_clock_out`: Boolean apakah bisa absen keluar
        - `clock_in_deadline`: Jam batas absen masuk (08:00:00)
        - `clock_out_start_time`: Jam mulai bisa absen keluar (16:00:00)
        - `time_message`: Pesan informatif tentang waktu

### Frontend (index.blade.php)

1. **Update Button States**

    - Tombol absen masuk disabled jika sudah lewat jam 8 atau sudah absen masuk
    - Tombol absen keluar disabled jika belum jam 4 sore, belum absen masuk, atau sudah absen keluar

2. **Enhanced Status Display**

    - Menampilkan waktu saat ini
    - Menampilkan pesan waktu yang informatif
    - Menampilkan batas waktu absen masuk/keluar

3. **Improved Event Handlers**
    - Validasi waktu sebelum membuka kamera
    - Pesan error yang lebih informatif dengan detail waktu

## Cara Kerja

### Skenario Absen Masuk

-   **Sebelum 08:00**: ✅ Bisa absen masuk
-   **Setelah 08:00**: ❌ Tidak bisa absen masuk, tombol disabled dengan pesan error

### Skenario Absen Keluar

-   **Sebelum 16:00**: ❌ Tidak bisa absen keluar, tombol disabled
-   **Setelah 16:00**: ✅ Bisa absen keluar (jika sudah absen masuk)

## File yang Dimodifikasi

1. **app/Http/Controllers/AbsensiController.php**

    - Method `clockIn()`: Tambah validasi waktu <= 08:00
    - Method `clockOut()`: Tambah validasi waktu >= 16:00
    - Method `getTodayStatus()`: Tambah informasi time_status
    - Method `getTimeMessage()`: Helper untuk pesan waktu

2. **resources/views/index.blade.php**
    - Function `updateButtonStates()`: Tambah logika disable berdasarkan waktu
    - Function `updateStatusDisplay()`: Tambah tampilan informasi waktu
    - Event handlers: Tambah validasi waktu sebelum aksi

## Testing

Telah dibuat script testing (`test-time-validation.php`) yang memverifikasi:

-   Logika validasi waktu berfungsi benar
-   API response sesuai format yang diharapkan
-   Berbagai skenario waktu telah dicakup

## Konfigurasi Waktu

Untuk mengubah jam kerja, edit nilai berikut:

**Backend (AbsensiController.php):**

```php
$clockInDeadline = Carbon::today()->setTime(8, 0, 0); // Jam 08:00
$clockOutStartTime = Carbon::today()->setTime(16, 0, 0); // Jam 16:00
```

**Timezone:** Asia/Jakarta (WIB) - sesuai konfigurasi Laravel

## Catatan

-   Sistem menggunakan timezone server (WIB)
-   Validasi dilakukan di backend dan frontend untuk keamanan
-   UI memberikan feedback yang jelas kepada user tentang status waktu
-   Tombol otomatis disabled ketika di luar jam kerja
