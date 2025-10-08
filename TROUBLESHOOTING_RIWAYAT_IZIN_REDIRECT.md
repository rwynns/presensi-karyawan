# TROUBLESHOOTING: Menu Riwayat Izin Redirect ke Pengajuan

## Masalah Dilaporkan

-   Menu "Riwayat Izin" di navbar mengarahkan ke halaman pengajuan instead of riwayat
-   User tidak bisa mengakses halaman `karyawan/izin` (index)

## Investigasi yang Dilakukan

### 1. **Route Analysis** ✅

```bash
php artisan route:list | Select-String "izin"
```

-   Route `karyawan.izin.index` tersedia: `GET karyawan/izin`
-   Navbar menggunakan route yang benar: `{{ route('karyawan.izin.index') }}`

### 2. **Controller Check** ✅

-   `App\Http\Controllers\Karyawan\IzinController@index` berfungsi normal
-   Method index mengembalikan view `karyawan.izin.index` dengan data yang benar

### 3. **Middleware Investigation** 🔍

Route menggunakan middleware: `check.role:2,3`

-   Role 2 = Karyawan
-   Role 3 = User lain (jika ada)
-   Memerlukan user aktif (`is_active = true`)

## Kemungkinan Penyebab

### 1. **User Role Issue** ⚠️

User yang login mungkin tidak memiliki `role_id = 2` atau `role_id = 3`

### 2. **User Not Active** ⚠️

User mungkin belum diaktivasi (`is_active = false`)

### 3. **Session Problem** ⚠️

Session corrupt atau middleware redirect

## Debugging Steps

### Tambahkan Debug Route

```php
Route::get('/debug-user', function () {
    $user = Auth::user();
    return response()->json([
        'user_id' => $user->id,
        'nama' => $user->nama,
        'role_id' => $user->role_id,
        'role_name' => $user->role->nama_role ?? 'No role',
        'is_active' => $user->is_active,
        'can_access_karyawan_routes' => in_array($user->role_id, [2, 3]),
        'izin_index_url' => route('karyawan.izin.index')
    ]);
});
```

### Test Steps:

1. **Akses** `http://localhost/debug-user`
2. **Periksa output** untuk memastikan:
    - `role_id`: harus 2 atau 3
    - `is_active`: harus true
    - `can_access_karyawan_routes`: harus true

## Solusi yang Dilakukan

### 1. **Clear Cache** ✅

```bash
php artisan optimize:clear
```

### 2. **Add Debug Route** ✅

Route debug ditambahkan untuk investigasi lebih lanjut

## Next Steps

### Jika `role_id` bukan 2 atau 3:

```sql
UPDATE users SET role_id = 2 WHERE id = [user_id];
```

### Jika `is_active` = false:

```sql
UPDATE users SET is_active = 1 WHERE id = [user_id];
```

### Jika masalah masih ada:

1. Check browser console untuk JavaScript errors
2. Check Laravel logs: `storage/logs/laravel.log`
3. Test direct URL access: `http://localhost/karyawan/izin`

## File yang Dimodifikasi:

-   `routes/web.php` - Added debug route

## Status:

🔍 **Under Investigation** - Menunggu hasil debug user info

---

**Note**: Debug route akan dihapus setelah masalah terselesaikan untuk keamanan.
