# Implementasi Fitur Izin Masuk Terlambat dan Pulang Awal

## Overview

Sistem presensi karyawan telah ditambahkan fitur baru yang memungkinkan karyawan mengajukan izin untuk:

1. **Izin Masuk Terlambat** - Karyawan bisa masuk setelah jam 08:00 dengan izin yang disetujui
2. **Izin Pulang Awal** - Karyawan bisa pulang sebelum jam 16:00 tanpa perlu absen keluar

## Fitur yang Ditambahkan

### 1. Database Schema

-   **Migration**: `2025_10_07_132148_add_time_permissions_to_izin_table.php`
-   **Kolom baru pada tabel `izin`**:
    -   `jam_masuk_maksimal` (time, nullable) - untuk izin masuk terlambat
    -   `jam_pulang_awal` (time, nullable) - untuk izin pulang awal
    -   `is_hari_ini` (boolean) - flag untuk izin yang berlaku hari ini

### 2. Model Updates

-   **App\Models\Izin**:
    -   Menambahkan fillable fields untuk kolom baru
    -   Method `isTimeBasedPermission()` - cek apakah izin berbasis waktu
    -   Method `getTodayTimePermission()` - ambil izin waktu hari ini
    -   Method `hasLateArrivalPermissionToday()` - cek izin terlambat
    -   Method `hasEarlyDeparturePermissionToday()` - cek izin pulang awal

### 3. Controller Updates

#### IzinController

-   Validasi khusus untuk jenis izin berbasis waktu
-   Field `jam_masuk_maksimal` wajib untuk izin terlambat (min 08:01)
-   Field `jam_pulang_awal` wajib untuk izin pulang awal (max 15:59)

#### AbsensiController

-   **clockIn()**: Memeriksa izin terlambat dan memperpanjang batas waktu absen masuk
-   **clockOut()**: Memeriksa izin pulang awal dan memungkinkan absen keluar lebih awal
-   **getTodayStatus()**: Menampilkan status izin khusus di UI
-   **autoClockOutEarlyDeparture()**: Auto clock-out untuk karyawan dengan izin pulang awal

### 4. Form Pengajuan Izin

-   **resources/views/karyawan/izin/create.blade.php**:
    -   Dropdown dengan grouping "Izin Reguler" dan "Izin Waktu Khusus"
    -   Field waktu dinamis yang muncul berdasarkan jenis izin
    -   JavaScript untuk menampilkan/menyembunyikan field waktu
    -   Auto-fill tanggal untuk izin hari ini

### 5. UI Dashboard

-   **resources/views/index.blade.php**:
    -   Status card menampilkan informasi izin khusus
    -   Indikator visual untuk izin terlambat (kuning) dan pulang awal
    -   Button absen keluar otomatis disabled untuk karyawan dengan izin pulang awal
    -   Pesan informatif tentang batas waktu yang diperpanjang

## Cara Kerja

### Izin Masuk Terlambat

1. Karyawan mengajukan izin dengan jenis "Izin Masuk Terlambat"
2. Menentukan jam masuk maksimal (setelah 08:00)
3. Setelah disetujui admin:
    - Sistem memperpanjang batas waktu absen masuk
    - UI menampilkan status "Izin terlambat sampai [jam]"
    - Karyawan bisa absen masuk sampai batas waktu yang ditentukan

### Izin Pulang Awal

1. Karyawan mengajukan izin dengan jenis "Izin Pulang Awal"
2. Menentukan jam pulang awal (sebelum 16:00)
3. Setelah disetujui admin:
    - Sistem memungkinkan "absen keluar" lebih awal
    - Tombol absen keluar otomatis disabled
    - Karyawan tidak perlu melakukan absen keluar manual
    - Auto clock-out pada jam yang ditentukan

## API Endpoints

### Existing (Modified)

-   `POST /absensi/clock-in` - Cek izin terlambat
-   `POST /absensi/clock-out` - Cek izin pulang awal
-   `GET /absensi/status` - Return status izin khusus

### New

-   `POST /absensi/auto-clockout-early` - Auto clock-out izin pulang awal

## Response Format

### getTodayStatus() Response

```json
{
    "success": true,
    "data": {
        "has_clocked_in": false,
        "has_clocked_out": false,
        "jam_masuk": null,
        "jam_keluar": null,
        "lokasi_penempatan": "Kantor Pusat",
        "special_permissions": {
            "has_late_permission": true,
            "late_permission_until": "09:30:00",
            "has_early_departure": false,
            "early_departure_from": null,
            "early_departure_auto_clockout": false
        },
        "time_status": {
            "current_time": "08:30:00",
            "can_clock_in": true,
            "can_clock_out": false,
            "clock_in_deadline": "09:30:00",
            "clock_out_start_time": "16:00:00",
            "time_message": "Waktu absen masuk tersisa 60 menit (Ada izin terlambat sampai 09:30:00)"
        }
    }
}
```

## Validasi

### Form Validation

-   `jam_masuk_maksimal`: required jika izin terlambat, format H:i, setelah 08:00
-   `jam_pulang_awal`: required jika pulang awal, format H:i, sebelum 16:00

### Business Logic

-   Izin terlambat: batas maksimal jam 12:00 (noon)
-   Izin pulang awal: batas minimal jam 12:00, maksimal 15:59
-   Tidak bisa mengajukan keduanya dalam satu hari
-   Validasi lokasi tetap berlaku untuk semua jenis absensi

## Migration Commands

```bash
php artisan make:migration add_time_permissions_to_izin_table
php artisan migrate
```

## Testing

-   Test form submission dengan berbagai jenis izin
-   Test validasi waktu dengan dan tanpa izin khusus
-   Test UI responsiveness untuk status izin
-   Test auto clock-out functionality

## Future Enhancements

1. Scheduler untuk auto clock-out
2. Notifikasi untuk admin tentang izin khusus
3. Laporan khusus untuk karyawan dengan izin waktu
4. Batas maksimal izin terlambat per bulan
