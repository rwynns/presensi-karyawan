# Panduan Akses Fitur Lokasi Penempatan

## 📍 Cara Mengakses Halaman Lokasi Penempatan

### Untuk Admin:

1. **Login** ke sistem dengan akun admin
2. Setelah masuk dashboard, lihat **sidebar menu** di sebelah kiri
3. Klik menu **"Lokasi Penempatan"**
    - Menu ini berada di bagian admin dengan ikon lokasi 📍
    - Menu akan aktif (highlighted) ketika Anda berada di halaman lokasi penempatan

### Navigasi Menu:

```
Dashboard Admin
├── Dashboard
├── Kelola Karyawan
├── Aktivasi Akun
├── Data Absensi
├── Kelola Izin
├── Master Jabatan
├── 📍 Lokasi Penempatan  ← Menu ini
├── Master Lokasi (jika ada)
├── Laporan
└── Pengaturan
```

## 🗺️ Fitur Yang Tersedia

### 1. **Daftar Lokasi**

-   Lihat semua lokasi penempatan yang sudah dibuat
-   Informasi: nama lokasi, alamat, radius, deskripsi
-   Status peta provider yang aktif

### 2. **Tambah Lokasi Baru**

-   Klik tombol **"Tambah Lokasi"**
-   Sistem akan menggunakan provider peta yang aktif:
    -   **Google Maps**: Dengan fitur Places autocomplete
    -   **OpenStreetMap**: Dengan Nominatim search

### 3. **Edit Lokasi**

-   Klik tombol **"Edit"** pada lokasi yang ingin diubah
-   Interface akan menyesuaikan dengan provider peta aktif

### 4. **Detail Lokasi**

-   Klik tombol **"Detail"** untuk melihat informasi lengkap
-   Peta interaktif dengan marker dan radius area

### 5. **Hapus Lokasi**

-   Klik tombol **"Hapus"** dengan konfirmasi SweetAlert

## 🔄 Switching Provider Peta

### Status Provider Aktif:

-   Cek di **Dashboard Admin** bagian atas
-   Komponen berwarna menampilkan provider yang aktif:
    -   **Google Maps** = Ikon merah
    -   **OpenStreetMap** = Ikon hijau

### Cara Mengganti Provider:

```bash
# Via Terminal/Command Line:
php artisan map:provider switch google         # Ganti ke Google Maps
php artisan map:provider switch openstreetmap  # Ganti ke OpenStreetMap

# Cek status saat ini:
php artisan map:provider status

# Validasi konfigurasi:
php artisan map:provider validate
```

## 🚀 Quick Start Guide

### Langkah Cepat:

1. **Login** → **Dashboard Admin**
2. **Sidebar** → **Lokasi Penempatan**
3. **Tambah Lokasi** → Isi form → **Pilih di peta** → **Simpan**
4. **Selesai!** Lokasi siap digunakan untuk presensi karyawan

### Tips Penggunaan:

-   **Google Maps**: Gunakan search box untuk mencari alamat
-   **OpenStreetMap**: Ketik alamat di search box atau klik langsung di peta
-   **Radius**: Tentukan jarak toleransi presensi (dalam meter)
-   **Deskripsi**: Berikan keterangan tambahan untuk lokasi

## 🔧 Troubleshooting

### Jika Menu Tidak Muncul:

-   Pastikan login sebagai **Admin** (role_id = 1)
-   Clear cache: `php artisan cache:clear`
-   Refresh browser

### Jika Peta Tidak Muncul:

-   **Google Maps**: Pastikan API key sudah di set di `.env`
-   **OpenStreetMap**: Cek koneksi internet
-   Lihat console browser untuk error JavaScript

### Jika Ingin Ganti Provider:

-   Gunakan command artisan `map:provider switch`
-   Restart aplikasi setelah switch
-   Validasi dengan `map:provider validate`

## 📚 Dokumentasi Teknis

### File Terkait:

-   **Routes**: `web.php` → `admin.lokasi-penempatan.*`
-   **Controller**: `LokasiPenempatanController.php`
-   **Views**: `resources/views/admin/lokasi-penempatan/`
-   **Services**: `app/Services/MapService/`

### Command Artisan:

```bash
php artisan map:provider status     # Lihat status provider
php artisan map:provider switch     # Ganti provider interaktif
php artisan map:provider validate   # Validasi konfigurasi
```

---

**💡 Pro Tips:**

-   Gunakan Google Maps untuk akurasi tinggi dan fitur lengkap
-   Gunakan OpenStreetMap untuk alternatif gratis tanpa API key
-   Set radius lokasi sesuai kebutuhan (biasanya 50-100 meter)
-   Test lokasi dengan mencoba presensi dari aplikasi mobile

**🎯 Tujuan Akhir:**
Lokasi yang dibuat di sini akan digunakan untuk:

-   Validasi presensi karyawan berdasarkan GPS
-   Pembatasan area presensi dengan radius tertentu
-   Laporan kehadiran berdasarkan lokasi kerja
