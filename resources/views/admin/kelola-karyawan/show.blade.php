@extends('layouts.dashboard')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="py-4">
        <div class="flex items-center space-x-2 mb-6">
            <a href="{{ route('admin.kelola-karyawan.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="font-bold text-2xl">Detail Karyawan</h1>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Karyawan Info Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-primary-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-lg font-bold text-white font-inter">
                                    {{ strtoupper(substr($kelola_karyawan->nama, 0, 1)) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-white font-semibold font-inter text-xl">{{ $kelola_karyawan->nama }}</h2>
                                <p class="text-primary-100 text-sm font-inter">{{ $kelola_karyawan->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if ($kelola_karyawan->is_active)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 font-inter">
                                    <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 font-inter">
                                    <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 font-inter">No. HP</h3>
                            <p class="mt-1 text-sm text-gray-900 font-inter">{{ $kelola_karyawan->no_hp ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 font-inter">Jabatan</h3>
                            <p class="mt-1 text-sm text-gray-900 font-inter">
                                {{ $kelola_karyawan->jabatanRelation->nama_jabatan ?? '-' }}
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500 font-inter">Lokasi Penempatan</h3>
                            <p class="mt-1 text-sm text-gray-900 font-inter">
                                {{ $kelola_karyawan->lokasi->nama_lokasi ?? '-' }}
                            </p>
                            @if ($kelola_karyawan->lokasi)
                                <p class="text-xs text-gray-500 font-inter mt-1">
                                    {{ $kelola_karyawan->lokasi->alamat_lengkap }}</p>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500 font-inter">Alamat Lengkap</h3>
                            <p class="mt-1 text-sm text-gray-900 font-inter">{{ $kelola_karyawan->alamat ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 font-inter">Tanggal Bergabung</h3>
                            <p class="mt-1 text-sm text-gray-900 font-inter">
                                {{ $kelola_karyawan->created_at ? $kelola_karyawan->created_at->format('d F Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 font-inter">Terakhir Update</h3>
                            <p class="mt-1 text-sm text-gray-900 font-inter">
                                {{ $kelola_karyawan->updated_at ? $kelola_karyawan->updated_at->format('d F Y H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 font-inter">Aksi Cepat</h3>
                </div>
                <div class="p-4 space-y-3">
                    <a href="{{ route('admin.kelola-karyawan.edit', $kelola_karyawan) }}"
                        class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors font-inter">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Karyawan
                    </a>

                    @if (!$kelola_karyawan->is_active)
                        <form action="{{ route('admin.aktivasi.activate', $kelola_karyawan) }}" method="POST"
                            class="activate-form">
                            @csrf
                            @method('PATCH')
                            <button type="button"
                                class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors activate-btn font-inter"
                                data-nama="{{ $kelola_karyawan->nama }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Aktifkan Akun
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.aktivasi.deactivate', $kelola_karyawan) }}" method="POST"
                            class="deactivate-form">
                            @csrf
                            @method('PATCH')
                            <button type="button"
                                class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors deactivate-btn font-inter"
                                data-nama="{{ $kelola_karyawan->nama }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nonaktifkan Akun
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('admin.kelola-karyawan.destroy', $kelola_karyawan) }}" method="POST"
                        class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors delete-btn font-inter"
                            data-nama="{{ $kelola_karyawan->nama }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Hapus Karyawan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics Card -->
            @if ($kelola_karyawan->lokasi)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 font-inter">Informasi Lokasi Kerja</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 font-inter uppercase">Nama Lokasi</h4>
                            <p class="text-sm text-gray-900 font-inter">{{ $kelola_karyawan->lokasi->nama_lokasi }}</p>
                        </div>

                        @if (isset($kelola_karyawan->lokasi->jam_masuk) && isset($kelola_karyawan->lokasi->jam_pulang))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 font-inter uppercase">Jam Kerja</h4>
                                <p class="text-sm text-gray-900 font-inter">
                                    {{ Carbon\Carbon::parse($kelola_karyawan->lokasi->jam_masuk)->format('H:i') }} -
                                    {{ Carbon\Carbon::parse($kelola_karyawan->lokasi->jam_pulang)->format('H:i') }}
                                </p>
                            </div>
                        @endif

                        @if (isset($kelola_karyawan->lokasi->radius))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 font-inter uppercase">Radius Presensi</h4>
                                <p class="text-sm text-gray-900 font-inter">{{ $kelola_karyawan->lokasi->radius }} meter
                                </p>
                            </div>
                        @endif

                        @if (isset($kelola_karyawan->lokasi->toleransi_keterlambatan))
                            <div>
                                <h4 class="text-xs font-medium text-gray-500 font-inter uppercase">Toleransi Keterlambatan
                                </h4>
                                <p class="text-sm text-gray-900 font-inter">
                                    {{ $kelola_karyawan->lokasi->toleransi_keterlambatan }}
                                    menit</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle activate button clicks
            document.querySelectorAll('.activate-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const nama = this.getAttribute('data-nama');
                    const form = this.closest('.activate-form');

                    Swal.fire({
                        title: 'Konfirmasi Aktivasi',
                        text: `Apakah Anda yakin ingin mengaktivasi akun ${nama}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Aktifkan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle deactivate button clicks
            document.querySelectorAll('.deactivate-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const nama = this.getAttribute('data-nama');
                    const form = this.closest('.deactivate-form');

                    Swal.fire({
                        title: 'Konfirmasi Nonaktifkan',
                        text: `Apakah Anda yakin ingin menonaktifkan akun ${nama}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Nonaktifkan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const nama = this.getAttribute('data-nama');
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `Apakah Anda yakin ingin menghapus karyawan <strong>${nama}</strong>?<br><br><small class="text-gray-500">Data yang dihapus tidak dapat dikembalikan!</small>`,
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
