# Setup Google Maps API Key

Fitur lokasi penempatan menggunakan Google Maps API untuk memudahkan admin dalam memilih lokasi. Ikuti langkah berikut untuk mengatur API key:

## 1. Mendapatkan Google Maps API Key

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang sudah ada
3. Aktifkan API berikut:

    - Maps JavaScript API
    - Places API
    - Geocoding API

4. Buat credentials (API Key):
    - Pergi ke "Credentials" di sidebar
    - Klik "Create Credentials" > "API Key"
    - Copy API key yang dihasilkan

## 2. Konfigurasi di Laravel

1. Buka file `.env` di root project
2. Tambahkan atau update baris berikut:

    ```
    GOOGLE_MAPS_API_KEY=your_actual_api_key_here
    ```

3. Ganti `your_actual_api_key_here` dengan API key yang sudah didapat dari Google Cloud Console

## 3. Pembatasan API Key (Rekomendasi)

Untuk keamanan, batasi penggunaan API key:

1. Di Google Cloud Console, buka API key yang dibuat
2. Klik "Edit"
3. Di bagian "Application restrictions":

    - Pilih "HTTP referrers (web sites)"
    - Tambahkan domain aplikasi Anda, contoh:
        - `localhost:8000/*` (untuk development)
        - `yourdomain.com/*` (untuk production)

4. Di bagian "API restrictions":
    - Pilih "Restrict key"
    - Pilih APIs yang diperlukan:
        - Maps JavaScript API
        - Places API
        - Geocoding API

## 4. Testing

Setelah konfigurasi selesai:

1. Buka halaman admin > Lokasi Penempatan > Tambah Lokasi
2. Pastikan peta Google Maps muncul
3. Coba fitur pencarian lokasi
4. Klik pada peta untuk memindahkan marker

## 5. Troubleshooting

### Error: "This page can't load Google Maps correctly"

-   Pastikan API key sudah benar di file `.env`
-   Pastikan Maps JavaScript API sudah diaktifkan
-   Cek pembatasan domain di Google Cloud Console

### Error: "This API project is not authorized to use this API"

-   Pastikan Places API sudah diaktifkan
-   Pastikan Geocoding API sudah diaktifkan

### Peta tidak muncul

-   Buka Developer Tools (F12)
-   Cek Console untuk error messages
-   Pastikan tidak ada AdBlock yang memblokir Google Maps

## 6. Biaya

Google Maps API memiliki free tier yang cukup untuk penggunaan normal:

-   Maps JavaScript API: 28,000 map loads per bulan gratis
-   Places API: $2.83-$17 per 1000 requests (tergantung jenis request)
-   Geocoding API: $5 per 1000 requests

Monitor penggunaan di Google Cloud Console untuk menghindari biaya tak terduga.

## 7. Alternatif untuk Development

Jika tidak ingin menggunakan Google Maps API key saat development, Anda bisa:

1. Gunakan koordinat manual (disable Google Maps sementara)
2. Gunakan OpenStreetMap (perlu modifikasi kode)
3. Gunakan API key demo (terbatas dan tidak untuk production)

Tapi untuk pengalaman terbaik dan fitur lengkap, disarankan menggunakan Google Maps API key yang valid.
