@extends('layouts.dashboard')

@section('title', 'Edit Lokasi Penempatan')

@section('content')
    <div class="main-container min-h-screen bg-gray-50 overflow-y-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-full overflow-visible">
            <!-- Header -->
            <div class="flex items-center space-x-2 mb-6">
                <a href="{{ route('admin.lokasi-penempatan.show', $lokasiPenempatan) }}"
                    class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="font-bold text-2xl text-gray-900">Edit Lokasi Penempatan</h1>
            </div>

            <!-- Alert Messages -->
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium">Terdapat kesalahan pada form:</div>
                            <ul class="mt-2 text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Container -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Lokasi</h2>
                    <p class="text-sm text-gray-600 mt-1">Ubah informasi lokasi penempatan</p>
                </div>

                <form action="{{ route('admin.lokasi-penempatan.update', $lokasiPenempatan) }}" method="POST"
                    id="locationForm" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="max-w-6xl space-y-6">
                        <!-- Nama Lokasi -->
                        <div>
                            <label for="nama_lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lokasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_lokasi" name="nama_lokasi"
                                value="{{ old('nama_lokasi', $lokasiPenempatan->nama_lokasi) }}"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('nama_lokasi') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                placeholder="Misal: Kantor Pusat Jakarta" required>
                            @error('nama_lokasi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div>
                            <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 resize-none {{ $errors->has('alamat_lengkap') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                placeholder="Alamat lengkap lokasi" required>{{ old('alamat_lengkap', $lokasiPenempatan->alamat_lengkap) }}</textarea>
                            <div class="mt-2 flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Masukkan alamat selengkap mungkin untuk memudahkan lokasi
                            </div>
                            @error('alamat_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Koordinat -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                                    Latitude <span class="text-red-500">*</span>
                                    <span class="text-xs text-gray-500 font-normal">(dapat diedit manual)</span>
                                </label>
                                <input type="number" id="latitude" name="latitude" step="0.00000001"
                                    value="{{ old('latitude', $lokasiPenempatan->latitude) }}"
                                    class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 text-gray-900 text-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('latitude') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                    placeholder="Contoh: -6.200000" required>
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                                    Longitude <span class="text-red-500">*</span>
                                    <span class="text-xs text-gray-500 font-normal">(dapat diedit manual)</span>
                                </label>
                                <input type="number" id="longitude" name="longitude" step="0.00000001"
                                    value="{{ old('longitude', $lokasiPenempatan->longitude) }}"
                                    class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 text-gray-900 text-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('longitude') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                    placeholder="Contoh: 106.816666" required>
                                @error('longitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-start space-x-2 text-xs text-gray-500">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Anda dapat mengedit koordinat secara manual atau mendapatkannya dari Google Maps atau
                                GPS.</span>
                        </div>

                        <!-- Radius -->
                        <div>
                            <label for="radius" class="block text-sm font-medium text-gray-700 mb-2">
                                Radius Presensi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="radius" name="radius" min="10" max="1000"
                                    value="{{ old('radius', $lokasiPenempatan->radius) }}"
                                    class="block w-full px-3 py-2 pr-16 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('radius') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                    placeholder="100" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">meter</span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Jarak maksimal untuk melakukan presensi (10-1000 meter)
                            </p>
                            @error('radius')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jam Kerja -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="jam_masuk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Masuk <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="jam_masuk" name="jam_masuk"
                                    value="{{ old('jam_masuk', $lokasiPenempatan->jam_masuk ? $lokasiPenempatan->jam_masuk->format('H:i') : '08:00') }}"
                                    class="block w-full px-3 py-2 border rounded-md shadow-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('jam_masuk') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                    required>
                                @error('jam_masuk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="jam_pulang" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Pulang <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="jam_pulang" name="jam_pulang"
                                    value="{{ old('jam_pulang', $lokasiPenempatan->jam_pulang ? $lokasiPenempatan->jam_pulang->format('H:i') : '17:00') }}"
                                    class="block w-full px-3 py-2 border rounded-md shadow-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('jam_pulang') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                    required>
                                @error('jam_pulang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Toleransi Keterlambatan -->
                        <div>
                            <label for="toleransi_keterlambatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Toleransi Keterlambatan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="toleransi_keterlambatan" name="toleransi_keterlambatan"
                                    min="0" max="120"
                                    value="{{ old('toleransi_keterlambatan', $lokasiPenempatan->toleransi_keterlambatan ?? 15) }}"
                                    class="block w-full px-3 py-2 pr-16 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('toleransi_keterlambatan') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                    required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">menit</span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Batas waktu keterlambatan yang masih bisa ditoleransi
                                (0-120 menit)
                            </p>
                            @error('toleransi_keterlambatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 resize-none {{ $errors->has('description') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                placeholder="Deskripsi lokasi (opsional)">{{ old('description', $lokasiPenempatan->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.lokasi-penempatan.show', $lokasiPenempatan) }}"
                            class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" id="submit-btn"
                            class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Simple form handling without map functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Get form elements
            const form = document.getElementById('locationForm');
            const submitBtn = document.getElementById('submit-btn');

            // Form validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    const latitude = document.getElementById('latitude').value;
                    const longitude = document.getElementById('longitude').value;
                    const nama = document.getElementById('nama_lokasi').value;
                    const alamat = document.getElementById('alamat_lengkap').value;
                    const radius = document.getElementById('radius').value;

                    // Basic validation
                    if (!nama.trim()) {
                        e.preventDefault();
                        alert('Nama lokasi penempatan harus diisi.');
                        document.getElementById('nama_lokasi').focus();
                        return false;
                    }

                    if (!alamat.trim()) {
                        e.preventDefault();
                        alert('Alamat harus diisi.');
                        document.getElementById('alamat_lengkap').focus();
                        return false;
                    }

                    if (!latitude || !longitude) {
                        e.preventDefault();
                        alert('Koordinat latitude dan longitude harus diisi.');
                        document.getElementById('latitude').focus();
                        return false;
                    }

                    // Validate coordinate format
                    const lat = parseFloat(latitude);
                    const lng = parseFloat(longitude);

                    if (isNaN(lat) || isNaN(lng)) {
                        e.preventDefault();
                        alert(
                            'Format koordinat tidak valid. Gunakan format desimal (contoh: -6.200000, 106.816666).'
                        );
                        return false;
                    }

                    if (lat < -90 || lat > 90) {
                        e.preventDefault();
                        alert('Latitude harus berada dalam rentang -90 sampai 90.');
                        document.getElementById('latitude').focus();
                        return false;
                    }

                    if (lng < -180 || lng > 180) {
                        e.preventDefault();
                        alert('Longitude harus berada dalam rentang -180 sampai 180.');
                        document.getElementById('longitude').focus();
                        return false;
                    }

                    if (!radius || radius < 10 || radius > 1000) {
                        e.preventDefault();
                        alert('Radius harus antara 10-1000 meter.');
                        document.getElementById('radius').focus();
                        return false;
                    }

                    // Validate working hours
                    const jamMasuk = document.getElementById('jam_masuk').value;
                    const jamPulang = document.getElementById('jam_pulang').value;

                    if (!jamMasuk || !jamPulang) {
                        e.preventDefault();
                        alert('Jam masuk dan jam pulang harus diisi.');
                        if (!jamMasuk) document.getElementById('jam_masuk').focus();
                        else document.getElementById('jam_pulang').focus();
                        return false;
                    }

                    // Convert time to minutes for comparison
                    const masukMinutes = timeToMinutes(jamMasuk);
                    const pulangMinutes = timeToMinutes(jamPulang);

                    if (pulangMinutes <= masukMinutes) {
                        e.preventDefault();
                        alert('Jam pulang harus lebih dari jam masuk.');
                        document.getElementById('jam_pulang').focus();
                        return false;
                    }

                    // Show loading state
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = `
                            <svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                                <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
                            </svg>
                            Menyimpan...
                        `;
                        submitBtn.disabled = true;
                    }
                });
            }
        });

        // Helper function to convert time to minutes
        function timeToMinutes(time) {
            const [hours, minutes] = time.split(':').map(Number);
            return hours * 60 + minutes;
        }
    </script>
@endpush
