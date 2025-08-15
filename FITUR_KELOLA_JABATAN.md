# Fitur Kelola Jabatan - Dokumentasi

## Overview

Fitur Kelola Jabatan memungkinkan admin untuk mengelola data jabatan karyawan dalam sistem presensi. Fitur ini mencakup operasi CRUD lengkap (Create, Read, Update, Delete) dengan antarmuka yang user-friendly.

## Fitur yang Tersedia

### 1. Daftar Jabatan (Index)

-   **Route**: `/admin/jabatan`
-   **Method**: GET
-   **Fitur**:
    -   Tampilan tabel data jabatan
    -   Pencarian berdasarkan nama jabatan atau kode jabatan
    -   Paginasi data
    -   Informasi jumlah karyawan per jabatan
    -   Action buttons (View, Edit, Delete)

### 2. Tambah Jabatan (Create)

-   **Route**: `/admin/jabatan/create`
-   **Method**: GET (form), POST (submit)
-   **Form Fields**:
    -   Kode Jabatan (max 20 karakter, unique, akan auto uppercase)
    -   Nama Jabatan (max 100 karakter, unique)
-   **Validasi**:
    -   Kode jabatan harus unik dan 2-20 karakter
    -   Nama jabatan harus unik dan 3-100 karakter
    -   Real-time validation dengan JavaScript

### 3. Detail Jabatan (Show)

-   **Route**: `/admin/jabatan/{id}`
-   **Method**: GET
-   **Informasi yang ditampilkan**:
    -   Informasi dasar jabatan
    -   Daftar karyawan yang memiliki jabatan tersebut
    -   Statistik (jumlah karyawan aktif dan total)
    -   Informasi waktu (dibuat/diperbarui)
    -   Action buttons (Edit, Delete jika memungkinkan)

### 4. Edit Jabatan (Edit)

-   **Route**: `/admin/jabatan/{id}/edit`
-   **Method**: GET (form), PUT (submit)
-   **Fitur**:
    -   Form yang sudah terisi dengan data lama
    -   Validasi yang sama dengan create
    -   Info card menampilkan statistik jabatan
    -   Tombol untuk melihat detail

### 5. Hapus Jabatan (Delete)

-   **Route**: `/admin/jabatan/{id}`
-   **Method**: DELETE
-   **Proteksi**: Jabatan tidak dapat dihapus jika masih memiliki karyawan

## Struktur File

### Controller

```
app/Http/Controllers/Admin/JabatanController.php
```

-   Resource controller lengkap dengan error handling
-   Logging untuk audit trail
-   Validasi komprehensif

### Model

```
app/Models/Jabatan.php
```

-   Relasi dengan User model
-   Mass assignment protection
-   Timestamps otomatis

### Views

```
resources/views/admin/jabatan/
├── index.blade.php     # Daftar jabatan
├── create.blade.php    # Form tambah jabatan
├── edit.blade.php      # Form edit jabatan
└── show.blade.php      # Detail jabatan
```

### Migration

```
database/migrations/2024_08_05_075424_create_jabatan_table.php
```

### Seeder

```
database/seeders/JabatanSeeder.php
```

-   Menyediakan data jabatan default

## Cara Menggunakan

### Untuk Admin:

1. **Mengakses Menu Jabatan**

    - Login sebagai admin
    - Klik menu "Kelola Jabatan" di sidebar

2. **Menambah Jabatan Baru**

    - Klik tombol "Tambah Jabatan"
    - Isi form dengan kode dan nama jabatan
    - Klik "Simpan Jabatan"

3. **Mencari Jabatan**

    - Gunakan search box di halaman index
    - Ketik nama atau kode jabatan
    - Pencarian akan otomatis submit setelah 500ms

4. **Melihat Detail Jabatan**

    - Klik icon mata (view) di tabel
    - Lihat informasi lengkap dan daftar karyawan

5. **Mengedit Jabatan**

    - Klik icon edit (pensil) di tabel
    - Atau klik tombol "Edit" di halaman detail
    - Ubah data yang diperlukan dan simpan

6. **Menghapus Jabatan**
    - Klik icon hapus (sampah) di tabel
    - Atau klik tombol "Hapus" di halaman detail
    - Konfirmasi penghapusan
    - **Catatan**: Jabatan dengan karyawan tidak dapat dihapus

## Validasi dan Error Handling

### Validasi Form

-   Kode jabatan: Required, string, max 20 karakter, unique
-   Nama jabatan: Required, string, max 100 karakter, unique
-   Auto uppercase untuk kode jabatan
-   Real-time validation feedback

### Error Handling

-   Try-catch di semua method controller
-   Logging error dengan context lengkap
-   User-friendly error messages
-   Redirect dengan session flash messages

### Proteksi Data

-   CSRF protection pada semua form
-   Foreign key constraints
-   Soft delete tidak digunakan (hard delete dengan proteksi)

## Integrasi dengan Sistem

### Relasi Database

-   `jabatan.id` → `users.jabatan_id` (One to Many)
-   Constraint: ON DELETE SET NULL

### Audit Trail

-   Semua operasi di-log dengan informasi:
    -   User ID yang melakukan aksi
    -   Data lama dan baru (untuk update)
    -   Timestamp operasi
    -   Request data (tanpa token)

## Styling dan UI

### Design System

-   Konsisten dengan halaman Kelola Lokasi Penempatan
-   Menggunakan Tailwind CSS
-   Responsive design
-   Icon dari Heroicons
-   Color scheme: Blue primary, dengan accent colors

### Interactive Elements

-   Hover effects pada buttons dan links
-   Loading states pada form submission
-   Confirmation dialogs untuk delete actions
-   Toast notifications untuk feedback
-   Auto-search dengan debouncing

## Tips Penggunaan

1. **Penamaan Kode Jabatan**

    - Gunakan singkatan yang jelas (MGR, SPV, STF)
    - Hindari karakter khusus
    - Maksimal 20 karakter

2. **Manajemen Jabatan**

    - Buat jabatan sebelum menambah karyawan
    - Gunakan hierarki yang jelas (CEO, Manager, Staff)
    - Review berkala untuk jabatan yang tidak terpakai

3. **Pencarian Efektif**
    - Cari berdasarkan kode untuk hasil cepat
    - Gunakan nama lengkap untuk pencarian detail
    - Manfaatkan fitur pagination untuk data banyak

## Troubleshooting

### Masalah Umum

1. **Jabatan tidak bisa dihapus**: Pastikan tidak ada karyawan yang menggunakan jabatan tersebut
2. **Kode sudah digunakan**: Gunakan kode yang unik
3. **Form tidak submit**: Periksa validasi JavaScript dan koneksi

### Log Location

-   Application logs: `storage/logs/laravel.log`
-   Search for: `JabatanController` untuk operasi terkait jabatan
