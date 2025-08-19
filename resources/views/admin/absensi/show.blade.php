@extends('layouts.dashboard')

@section('title', 'Detail Absensi')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Absensi</h1>
                    <p class="text-gray-600">Informasi lengkap data absensi karyawan</p>
                </div>
                <a href="{{ route('admin.absensi.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2">
                <!-- Employee Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Karyawan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-xl font-medium text-blue-800">
                                            {{ substr($absensi->user->nama, 0, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-lg font-medium text-gray-900">
                                        {{ $absensi->user->nama }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $absensi->user->email }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $absensi->user->jabatan->nama_jabatan ?? 'Tidak ada jabatan' }}
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Lokasi Penempatan:</span>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $absensi->lokasiPenempatan->nama_lokasi ?? 'Tidak ada lokasi' }}
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Status:</span>
                                    @php
                                        $statusClass = match ($absensi->status) {
                                            'masuk' => 'bg-green-100 text-green-800',
                                            'keluar' => 'bg-blue-100 text-blue-800',
                                            'izin' => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                        {{ ucfirst($absensi->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Absensi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Clock In Info -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Absen Masuk</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm text-gray-500">Tanggal:</span>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $absensi->tanggal->format('d F Y') }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Jam Masuk:</span>
                                        <div class="text-sm font-medium text-gray-900">
                                            @if ($absensi->jam_masuk)
                                                {{ $absensi->jam_masuk->format('H:i:s') }}
                                                @if ($absensi->jam_masuk->format('H:i:s') > '08:00:00')
                                                    <span
                                                        class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Terlambat</span>
                                                @else
                                                    <span
                                                        class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Tepat
                                                        Waktu</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">Belum absen masuk</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($absensi->latitude_masuk && $absensi->longitude_masuk)
                                        <div>
                                            <span class="text-sm text-gray-500">Koordinat:</span>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $absensi->latitude_masuk }}, {{ $absensi->longitude_masuk }}
                                            </div>
                                            <a href="https://www.google.com/maps?q={{ $absensi->latitude_masuk }},{{ $absensi->longitude_masuk }}"
                                                target="_blank" class="text-xs text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-external-link-alt mr-1"></i>Lihat di Maps
                                            </a>
                                        </div>
                                    @endif
                                    @if ($absensi->jarak_masuk)
                                        <div>
                                            <span class="text-sm text-gray-500">Jarak dari Kantor:</span>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ number_format($absensi->jarak_masuk) }} meter
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Clock Out Info -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Absen Keluar</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm text-gray-500">Jam Keluar:</span>
                                        <div class="text-sm font-medium text-gray-900">
                                            @if ($absensi->jam_keluar)
                                                {{ $absensi->jam_keluar->format('H:i:s') }}
                                                @if ($absensi->jam_keluar->format('H:i:s') < '17:00:00')
                                                    <span
                                                        class="ml-2 px-2 py-1 text-xs bg-orange-100 text-orange-800 rounded">Pulang
                                                        Awal</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">Belum absen keluar</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($absensi->latitude_keluar && $absensi->longitude_keluar)
                                        <div>
                                            <span class="text-sm text-gray-500">Koordinat:</span>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $absensi->latitude_keluar }}, {{ $absensi->longitude_keluar }}
                                            </div>
                                            <a href="https://www.google.com/maps?q={{ $absensi->latitude_keluar }},{{ $absensi->longitude_keluar }}"
                                                target="_blank" class="text-xs text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-external-link-alt mr-1"></i>Lihat di Maps
                                            </a>
                                        </div>
                                    @endif
                                    @if ($absensi->jarak_keluar)
                                        <div>
                                            <span class="text-sm text-gray-500">Jarak dari Kantor:</span>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ number_format($absensi->jarak_keluar) }} meter
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($absensi->keterangan)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <span class="text-sm text-gray-500">Keterangan:</span>
                                <div class="text-sm text-gray-900 mt-1">
                                    {{ $absensi->keterangan }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Location Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Lokasi</h3>
                        @if ($absensi->lokasiPenempatan)
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500">Nama Lokasi:</span>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $absensi->lokasiPenempatan->nama_lokasi }}
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Alamat:</span>
                                    <div class="text-sm text-gray-900">
                                        {{ $absensi->lokasiPenempatan->alamat }}
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Koordinat Kantor:</span>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $absensi->lokasiPenempatan->latitude }},
                                        {{ $absensi->lokasiPenempatan->longitude }}
                                    </div>
                                    <a href="https://www.google.com/maps?q={{ $absensi->lokasiPenempatan->latitude }},{{ $absensi->lokasiPenempatan->longitude }}"
                                        target="_blank" class="text-xs text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-external-link-alt mr-1"></i>Lihat di Maps
                                    </a>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Radius:</span>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($absensi->lokasiPenempatan->radius) }} meter
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Tidak ada informasi lokasi</p>
                        @endif
                    </div>
                </div>

                <!-- Work Duration -->
                @if ($absensi->jam_masuk && $absensi->jam_keluar)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Durasi Kerja</h3>
                            @php
                                $duration = $absensi->jam_keluar->diff($absensi->jam_masuk);
                                $hours = $duration->h;
                                $minutes = $duration->i;
                            @endphp
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600">
                                    {{ $hours }}j {{ $minutes }}m
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    Total waktu kerja
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                        <div class="space-y-3">
                            <button
                                onclick="deleteAbsensi({{ $absensi->id }}, '{{ $absensi->user->nama }}', '{{ $absensi->tanggal->format('d F Y') }}')"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>Hapus Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-3">Hapus Data Absensi</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="deleteMessage">
                        Apakah Anda yakin ingin menghapus data absensi ini?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 hover:bg-red-600 mr-2">
                        Hapus
                    </button>
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 hover:bg-gray-400">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;

        function deleteAbsensi(id, nama, tanggal) {
            deleteId = id;
            document.getElementById('deleteMessage').textContent =
                `Apakah Anda yakin ingin menghapus data absensi ${nama} tanggal ${tanggal}?`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteId = null;
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/absensi/${deleteId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
