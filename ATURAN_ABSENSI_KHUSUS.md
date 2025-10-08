# IMPLEMENTASI ATURAN ABSENSI KHUSUS

## Update: 8 Oktober 2025

### Aturan Baru yang Diimplementasikan:

#### 1. Izin Masuk Terlambat

**Aturan**: Jika karyawan mengajukan dan mendapat persetujuan izin masuk terlambat, maka:

-   ✅ **TIDAK PERLU** melakukan absen masuk
-   ✅ **TETAP BISA** melakukan absen keluar pada waktu normal
-   ✅ Kehadiran tetap tercatat sebagai "hadir dengan izin terlambat"

**Implementasi**:

-   Server: `AbsensiController@getTodayStatus()` - `can_clock_in` = false jika ada izin terlambat
-   Frontend: Tombol "Absen Masuk" disabled dengan pesan informatif
-   Status: Menampilkan "Izin terlambat aktif - Tidak perlu absen masuk"

#### 2. Izin Pulang Awal

**Aturan**: Jika karyawan mengajukan dan mendapat persetujuan izin pulang awal, maka:

-   ✅ **HARUS** melakukan absen masuk normal
-   ✅ **TIDAK PERLU** melakukan absen keluar (otomatis tercatat)
-   ✅ Sistem otomatis mencatat waktu keluar sesuai izin

**Implementasi**:

-   Server: `AbsensiController@getTodayStatus()` - logic untuk disable clock out
-   Frontend: Tombol "Absen Keluar" disabled jika ada izin pulang awal
-   Status: Menampilkan informasi izin pulang awal dengan keterangan "Tidak perlu absen keluar"

### File yang Dimodifikasi:

1. **app/Http/Controllers/AbsensiController.php**

    - Method `getTodayStatus()`: Update logic `can_clock_in` dan `can_clock_out`
    - Method `getTimeMessage()`: Update pesan untuk aturan baru
    - Tambah flag `has_late_permission_restriction` untuk frontend

2. **resources/views/index.blade.php**
    - Function `updateButtonStates()`: Logic disable tombol sesuai aturan baru
    - Function `updateStatusDisplay()`: Tampilan status yang jelas
    - Event handler Clock In: Pesan informatif untuk izin terlambat
    - Info izin khusus: Penjelasan aturan untuk user

### Tampilan untuk User:

#### Skenario 1: Ada Izin Terlambat

-   Status: "Izin terlambat aktif - Tidak perlu absen masuk" (biru)
-   Tombol Absen Masuk: Disabled (abu-abu)
-   Tombol Absen Keluar: Aktif (jika waktunya sudah tiba)
-   Info: "🔵 Izin masuk terlambat sampai XX:XX → Tidak perlu absen masuk, tetapi tetap bisa absen keluar"

#### Skenario 2: Ada Izin Pulang Awal (setelah absen masuk)

-   Status: "Sedang bekerja (Izin pulang awal jam XX:XX)"
-   Tombol Absen Masuk: Disabled (sudah absen)
-   Tombol Absen Keluar: Disabled (abu-abu)
-   Info: "🔵 Izin pulang awal jam XX:XX → Tidak perlu absen keluar (otomatis tercatat)"

#### Skenario 3: Normal (tanpa izin khusus)

-   Status: "Siap absen masuk" atau "Sedang bekerja"
-   Tombol Absen Masuk: Aktif sesuai waktu
-   Tombol Absen Keluar: Aktif sesuai waktu dan status absen masuk

### Validasi Backend:

Sistem tetap melakukan validasi di backend untuk memastikan:

-   User dengan izin terlambat tidak bisa clock in via API
-   User dengan izin pulang awal tidak perlu clock out
-   Semua aturan waktu dan lokasi tetap berlaku untuk yang tidak punya izin khusus

### Testing:

Untuk menguji implementasi:

1. Buat izin masuk terlambat → Cek tombol absen masuk disabled
2. Buat izin pulang awal → Cek tombol absen keluar disabled setelah absen masuk
3. Kombinasi izin → Pastikan logic tidak bentrok
4. User tanpa izin → Pastikan sistem normal seperti sebelumnya
