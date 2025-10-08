# FIX: Dashboard Admin Stats

## Masalah yang Ditemukan

-   Stats card "Izin/Sakit" menampilkan 0 padahal ada data izin di database
-   Query menggunakan status 'approved' tetapi data di database menggunakan 'disetujui'

## Perbaikan yang Dilakukan

### 1. Fix Query Status Izin

**File**: `app/Http/Controllers/Admin/AdminController.php`

**Sebelum**:

```php
$izinHariIni = Izin::whereDate('tanggal_mulai', '<=', $today)
    ->whereDate('tanggal_selesai', '>=', $today)
    ->where('status', 'approved') // ❌ Salah: data menggunakan 'disetujui'
    ->count();
```

**Sesudah**:

```php
$izinHariIni = Izin::whereDate('tanggal_mulai', '<=', $today)
    ->whereDate('tanggal_selesai', '>=', $today)
    ->where('status', 'disetujui') // ✅ Benar: sesuai data di database
    ->count();
```

### 2. Perbaikan Perhitungan "Tidak Hadir"

```php
// Pastikan tidak negatif (bisa terjadi jika ada duplikasi data)
$tidakHadir = max(0, $totalKaryawan - ($hadirHariIni + $izinHariIni));
```

### 3. Statistik Tambahan

-   `$totalIzinPending`: Jumlah izin yang menunggu persetujuan
-   `$absensiLengkap`: Jumlah karyawan yang sudah absen masuk dan keluar

### 4. UI Enhancement

-   Menambahkan indikator izin pending di card "Izin Hari Ini"
-   Label lebih spesifik: "Izin/Sakit" → "Izin Hari Ini"

## Hasil Setelah Perbaikan

### Data Statistik Hari Ini (2025-10-08):

-   **Total Karyawan**: 6 (non-admin)
-   **Hadir Hari Ini**: 0 (belum ada yang absen masuk)
-   **Izin Hari Ini**: 1 ✅ (sebelumnya 0, sekarang benar)
-   **Tidak Hadir**: 5 (6 - 0 - 1)

### Data Izin di Database:

-   Total izin: 5
-   Izin disetujui: 5 (semua izin sudah disetujui)
-   Izin untuk hari ini: 1 (ID: 9, izin masuk terlambat)

## Testing

Untuk memverifikasi perbaikan:

1. Akses dashboard admin: `/admin`
2. Card "Izin Hari Ini" sekarang menampilkan angka yang benar
3. Jika ada izin pending, akan muncul indikator tambahan

## Status Database Izin

```
Semua izin menggunakan status 'disetujui' bukan 'approved'
Pastikan konsistensi di seluruh aplikasi untuk menggunakan 'disetujui'
```
