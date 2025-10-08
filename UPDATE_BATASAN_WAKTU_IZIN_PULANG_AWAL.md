# UPDATE: Batasan Waktu Izin Pulang Awal

## Update: 8 Oktober 2025

### Perubahan yang Dilakukan

Berdasarkan permintaan user untuk membuat izin pulang awal lebih fleksibel.

### Sebelum:

```html
<input type="time" name="jam_pulang_awal" value="{{ old('jam_pulang_awal') }}"
    min="12:00" max="15:59"
```

### Sesudah:

```html
<input type="time" name="jam_pulang_awal" value="{{ old('jam_pulang_awal') }}"
    min="09:00" max="15:59"
```

### Detail Perubahan:

-   **File**: `resources/views/karyawan/izin/create.blade.php`
-   **Perubahan**: Mengubah batasan waktu minimum untuk "Jam Pulang Awal" dari `12:00` menjadi `09:00`
-   **Maksimal tetap**: `15:59` (sebelum jam kerja selesai pukul 16:00)

### Alasan Perubahan:

1. **Lebih Fleksibel**: Karyawan bisa mengajukan izin pulang awal mulai jam 9 pagi
2. **Kebutuhan Realistis**: Ada situasi dimana karyawan perlu pulang awal di pagi/siang hari
3. **User Request**: Berdasarkan screenshot yang menunjukkan batasan jam 12:00 terlalu kaku

### Rentang Waktu Baru:

-   **Minimum**: 09:00 (jam 9 pagi)
-   **Maksimum**: 15:59 (sebelum jam 16:00)
-   **Rentang**: 7 jam pilihan waktu pulang awal

### Impact:

✅ **Positif**:

-   Karyawan punya lebih banyak fleksibilitas waktu
-   Bisa mengakomodasi keperluan mendesak di pagi/siang hari
-   Form lebih mudah digunakan

⚠️ **Perhatian**:

-   Admin perlu memvalidasi alasan izin dengan lebih teliti
-   Potensi penyalahgunaan jika tidak dikontrol dengan baik

### Testing:

Coba buka form pengajuan izin → Pilih "Izin Pulang Awal" → Field "Jam Pulang Awal" sekarang bisa diisi mulai dari jam 09:00

Perubahan ini memberikan fleksibilitas yang lebih baik untuk karyawan yang membutuhkan izin pulang awal dengan alasan yang valid.
