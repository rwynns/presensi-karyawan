@extends('layouts.dashboard')

@section('title', 'Detail Lokasi Penempatan')

@section('content')
    <div class="main-container min-h-screen bg-gray-50 overflow-y-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-full overflow-visible">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.lokasi-penempatan.index') }}"
                        class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h1 class="font-bold text-2xl text-gray-900">Detail Lokasi Penempatan</h1>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.lokasi-penempatan.edit', $lokasiPenempatan) }}"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            <!-- Location Map Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Lokasi pada Peta</h2>
                    <p class="text-sm text-gray-600 mt-1">Tampilan lokasi tanpa peta interaktif</p>
                </div>
                <div class="p-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-8 text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-blue-500 text-white rounded-full mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $lokasiPenempatan->nama_lokasi }}</h3>
                        <p class="text-gray-600 mb-4">{{ $lokasiPenempatan->alamat_lengkap }}</p>
                        <div class="flex justify-center space-x-6 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v18m9-9H3"></path>
                                </svg>
                                <span class="font-mono">{{ $lokasiPenempatan->latitude }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v18m9-9H3"></path>
                                </svg>
                                <span class="font-mono">{{ $lokasiPenempatan->longitude }}</span>
                            </div>
                        </div>
                        <div class="flex justify-center space-x-3">
                            <button onclick="openInGoogleMaps()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                Buka di Google Maps
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Lokasi</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Nama Lokasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lokasi</label>
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-medium text-gray-900">
                                                {{ $lokasiPenempatan->nama_lokasi }}</p>
                                            @if ($lokasiPenempatan->description)
                                                <p class="text-sm text-gray-600">{{ $lokasiPenempatan->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                    <p class="text-gray-900 bg-gray-50 p-3 rounded-md">
                                        {{ $lokasiPenempatan->alamat_lengkap }}</p>
                                </div>

                                <!-- Koordinat -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                                        <div class="flex items-center space-x-2">
                                            <p class="text-gray-900 bg-gray-50 p-2 rounded-md text-sm font-mono flex-1">
                                                {{ $lokasiPenempatan->latitude }}
                                            </p>
                                            <button type="button"
                                                onclick="copyToClipboard('{{ $lokasiPenempatan->latitude }}')"
                                                class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                        <div class="flex items-center space-x-2">
                                            <p class="text-gray-900 bg-gray-50 p-2 rounded-md text-sm font-mono flex-1">
                                                {{ $lokasiPenempatan->longitude }}
                                            </p>
                                            <button type="button"
                                                onclick="copyToClipboard('{{ $lokasiPenempatan->longitude }}')"
                                                class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Radius -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Radius Presensi</label>
                                    <div class="flex items-center">
                                        <span
                                            class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.618V7.382a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                                </path>
                                            </svg>
                                            {{ $lokasiPenempatan->radius }} meter
                                        </span>
                                        <p class="text-xs text-gray-500 ml-3">Jarak maksimal untuk melakukan presensi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Statistics -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Statistik</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Karyawan Aktif</span>
                                    <span class="text-lg font-semibold text-green-600">
                                        {{ $lokasiPenempatan->users->where('is_active', true)->count() }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total Karyawan</span>
                                    <span class="text-lg font-semibold text-gray-900">
                                        {{ $lokasiPenempatan->users->count() }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dibuat</span>
                                    <span class="text-sm text-gray-900">
                                        {{ $lokasiPenempatan->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Diperbarui</span>
                                    <span class="text-sm text-gray-900">
                                        {{ $lokasiPenempatan->updated_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employees -->
                    @if ($lokasiPenempatan->users->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900">Karyawan di Lokasi Ini</h2>
                            </div>
                            <div class="divide-y divide-gray-200">
                                @foreach ($lokasiPenempatan->users->take(5) as $user)
                                    <div class="p-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-xs font-semibold text-white font-inter">
                                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $user->jabatanRelation->nama_jabatan ?? '-' }}</div>
                                            </div>
                                            <div>
                                                @if ($user->is_active)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($lokasiPenempatan->users->count() > 5)
                                    <div class="p-4 text-center">
                                        <span class="text-sm text-gray-500">
                                            dan {{ $lokasiPenempatan->users->count() - 5 }} karyawan lainnya
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Aksi</h2>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('admin.lokasi-penempatan.edit', $lokasiPenempatan) }}"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors inline-flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit Lokasi
                            </a>

                            @if ($lokasiPenempatan->users->count() == 0)
                                <form action="{{ route('admin.lokasi-penempatan.destroy', $lokasiPenempatan) }}"
                                    method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors inline-flex items-center justify-center delete-btn"
                                        data-nama="{{ $lokasiPenempatan->nama_lokasi }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus Lokasi
                                    </button>
                                </form>
                            @else
                                <div class="bg-gray-100 text-gray-500 px-4 py-2 rounded-md text-sm text-center">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tidak dapat dihapus karena masih digunakan karyawan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success toast
                alert('Koordinat berhasil disalin ke clipboard: ' + text);
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Koordinat berhasil disalin ke clipboard: ' + text);
            });
        }

        function copyCoordinates() {
            const lat = {{ $lokasiPenempatan->latitude }};
            const lng = {{ $lokasiPenempatan->longitude }};
            const coordinates = `${lat}, ${lng}`;
            copyToClipboard(coordinates);
        }

        function openInGoogleMaps() {
            const lat = {{ $lokasiPenempatan->latitude }};
            const lng = {{ $lokasiPenempatan->longitude }};
            const url = `https://www.google.com/maps?q=${lat},${lng}`;
            window.open(url, '_blank');
        }

        // Initialize when DOM is ready
        document.addEventListener("DOMContentLoaded", function() {
            // Handle delete button if exists
            const deleteBtn = document.querySelector('.delete-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const nama = this.getAttribute('data-nama');
                    const form = this.closest('.delete-form');

                    if (confirm(
                            `Apakah Anda yakin ingin menghapus lokasi ${nama}? Tindakan ini tidak dapat dibatalkan.`
                        )) {
                        form.submit();
                    }
                });
            }
        });
    </script>
@endpush
