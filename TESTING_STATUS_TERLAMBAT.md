# Testing Guide - Status Terlambat Fix

## Data Testing yang Telah Dibuat

Seeder `KaryawanAbsensiSeeder` telah berhasil membuat data testing dengan:

### 📝 **5 Akun Karyawan**

-   **Ahmad Rizki** - ahmad.rizki@company.com / password123
-   **Siti Nurhaliza** - siti.nurhaliza@company.com / password123
-   **Budi Santoso** - budi.santoso@company.com / password123
-   **Maya Sari** - maya.sari@company.com / password123
-   **Eko Prasetyo** - eko.prasetyo@company.com / password123

### 🏢 **3 Lokasi Penempatan**

1. **Kantor Pusat Jakarta** - Jam Masuk: 08:00, Jam Pulang: 17:00
2. **Kantor Cabang Surabaya** - Jam Masuk: 07:30, Jam Pulang: 16:30
3. **Remote Office** - Jam Masuk: 09:00, Jam Pulang: 18:00

### 📊 **Data Absensi (30 hari terakhir)**

-   Total ~135 record absensi (90% kehadiran)
-   70% kedatangan tepat waktu
-   30% kedatangan terlambat (5-60 menit)
-   Variasi jam pulang (normal, awal, lembur)

## 🧪 **Cara Testing**

### 1. **Test di Halaman Admin**

```
URL: http://127.0.0.1:8000/admin/absensi
Login: admin@admin.com / password123
```

-   Lihat status "Terlambat" dan "Tepat Waktu"
-   Filter berdasarkan lokasi
-   Cari berdasarkan nama karyawan

### 2. **Test di Halaman Karyawan**

```
URL: http://127.0.0.1:8000/login
```

Login dengan salah satu akun karyawan di atas, lalu ke:

-   **Dashboard**: http://127.0.0.1:8000/
-   **Riwayat Absen**: http://127.0.0.1:8000/karyawan/riwayat

### 3. **Verifikasi Konsistensi**

Pastikan status "Terlambat/Tepat Waktu" **sama persis** di:

-   ✅ Halaman Admin Absensi (List)
-   ✅ Halaman Admin Absensi (Detail/Show)
-   ✅ Halaman Karyawan Riwayat

## 🔍 **Yang Harus Dicek**

### ✅ **Status Terlambat Konsisten**

-   Admin dan Karyawan menampilkan status yang sama
-   Perhitungan berdasarkan jam masuk lokasi penempatan
-   Fallback ke 08:00 jika tidak ada jam masuk lokasi

### ✅ **Badge Display**

-   Badge hanya muncul jika ada jam_masuk
-   Warna: Merah (Terlambat), Hijau (Tepat Waktu)

### ✅ **Ringkasan Data**

-   Total hari kerja
-   Total hadir
-   Total tepat waktu
-   Total terlambat

## 🛠 **Logika Perbaikan**

### **Sebelum**

-   Admin List: Perhitungan manual di Blade template
-   Admin Detail: Perhitungan manual di Blade template
-   Karyawan: Perhitungan JavaScript di frontend
-   **Hasil**: Tidak konsisten

### **Sesudah**

-   Admin List: Menggunakan `$item->isLate()` dari model
-   Admin Detail: Menggunakan `$absensi->isLate()` dari model
-   Karyawan: Menggunakan `item.is_late` dari server
-   **Hasil**: Konsisten di semua halaman

## 📱 **Testing Tips**

1. **Cek berbagai karyawan** dengan lokasi berbeda
2. **Filter berdasarkan tanggal** tertentu
3. **Bandingkan halaman Admin vs Karyawan** untuk data yang sama
4. **Perhatikan jam masuk lokasi** yang berbeda-beda
5. **Test halaman detail** - klik salah satu record absensi di halaman admin untuk melihat detail
6. **Verifikasi konsistensi** status di list, detail, dan riwayat karyawan

## 🎯 **Expected Results**

-   Status terlambat **100% konsisten** di semua halaman
-   Perhitungan berdasarkan jam masuk lokasi penempatan masing-masing
-   UI responsif dan user-friendly
-   Data testing realistic dan variatif

---

**✨ Happy Testing!**

Jika menemukan inkonsistensi, silakan laporkan dengan detail:

-   URL halaman
-   Nama karyawan
-   Tanggal absensi
-   Status yang ditampilkan di masing-masing halaman
