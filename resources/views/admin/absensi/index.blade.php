@extends('layouts.dashboard')

@section('title', 'Data Absensi')

@section('content')
    <div class="py-4">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-2xl">Data Absensi</h1>
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

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
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

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
        <form method="GET" action="{{ route('admin.absensi.index') }}" id="filterForm"
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 font-inter"
                        placeholder="Cari nama karyawan...">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <select name="lokasi_id" id="lokasiSelect"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm font-inter focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Lokasi</option>
                    @foreach ($lokasi as $loc)
                        <option value="{{ $loc->id }}" {{ request('lokasi_id') == $loc->id ? 'selected' : '' }}>
                            {{ $loc->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.absensi.index') }}"
                    class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Main Data Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Table Header -->
        <div class="bg-primary-600 px-4 py-3">
            <div class="flex items-center justify-between">
                <h2 class="text-white font-semibold font-inter">Data Absensi Karyawan</h2>
                <div class="text-white text-sm font-inter flex items-center gap-4">
                    @if (request('lokasi_id'))
                        <span class="bg-white/20 px-2 py-1 rounded text-xs">
                            Lokasi: {{ $lokasi->find(request('lokasi_id'))->nama_lokasi ?? 'N/A' }}
                        </span>
                    @endif
                    @if (request('search'))
                        <span class="bg-white/20 px-2 py-1 rounded text-xs">
                            Cari: "{{ request('search') }}"
                        </span>
                    @endif
                    <span class="bg-white/20 px-2 py-1 rounded">{{ $absensi->total() }} Total</span>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            NO</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            KARYAWAN</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            TANGGAL</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            JAM MASUK</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            JAM KELUAR</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            BUKTI MASUK</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            BUKTI KELUAR</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            LOKASI</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            STATUS</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider font-inter">
                            AKSI</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($absensi as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-inter">
                                {{ ($absensi->currentPage() - 1) * $absensi->perPage() + $index + 1 }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold text-white font-inter">
                                            {{ strtoupper(substr($item->user->nama, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 font-inter">{{ $item->user->nama }}
                                        </div>
                                        <div class="text-xs text-gray-500 font-inter">{{ $item->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-inter">
                                {{ $item->tanggal->format('d M Y') }}
                                <div class="text-xs text-gray-500">{{ $item->tanggal->format('l') }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                @if ($item->jam_masuk)
                                    <div class="font-medium text-gray-900 font-inter">
                                        {{ $item->jam_masuk->format('H:i:s') }}</div>
                                    @php
                                        $jamMasukLokasi = $item->lokasiPenempatan?->jam_masuk;
                                        if ($jamMasukLokasi) {
                                            $jamMasukLokasiTime = \Carbon\Carbon::parse($jamMasukLokasi)->format('H:i:s');
                                            $jamMasukLokasiCarbon = $item->tanggal
                                                ->copy()
                                                ->setTimeFromTimeString($jamMasukLokasiTime);
                                            $jamMasukActual = $item->jam_masuk;

                                            $isTerlambat = $jamMasukActual->gt($jamMasukLokasiCarbon);
                                        } else {
                                            // Default to 08:00:00 if no schedule time is set
                                            $defaultTime = $item->tanggal->copy()->setTime(8, 0, 0);
                                            $isTerlambat = $item->jam_masuk->gt($defaultTime);
                                        }
                                    @endphp
                                    @if ($isTerlambat)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 font-inter">
                                            <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Terlambat
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 font-inter">
                                            <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Tepat Waktu
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-xs font-inter">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                @if ($item->jam_keluar)
                                    <div class="font-medium text-gray-900 font-inter">
                                        {{ $item->jam_keluar->format('H:i:s') }}</div>
                                    @php
                                        $jamPulangLokasi = $item->lokasiPenempatan?->jam_pulang;
                                        if ($jamPulangLokasi) {
                                            $jamPulangLokasiTime = \Carbon\Carbon::parse($jamPulangLokasi)->format(
                                                'H:i:s',
                                            );
                                            $jamPulangLokasiCarbon = $item->tanggal
                                                ->copy()
                                                ->setTimeFromTimeString($jamPulangLokasiTime);
                                            $jamKeluarActual = $item->jam_keluar;
                                            $pulangAwal = $jamKeluarActual->lt($jamPulangLokasiCarbon);
                                        } else {
                                            $pulangAwal = $item->jam_keluar->format('H:i:s') < '17:00:00';
                                        }
                                    @endphp
                                    @if ($pulangAwal)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 font-inter">
                                            <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Pulang Awal
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-xs font-inter">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                @if ($item->foto_masuk)
                                    <button
                                        onclick="showPhoto('{{ $item->foto_masuk }}', 'Bukti Masuk - {{ $item->user->nama }} - {{ $item->tanggal->format('d F Y') }}')"
                                        class="w-8 h-8 bg-primary-500 hover:bg-primary-600 text-white rounded-lg flex items-center justify-center transition-colors mx-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-400 text-xs font-inter">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                @if ($item->foto_keluar)
                                    <button
                                        onclick="showPhoto('{{ $item->foto_keluar }}', 'Bukti Keluar - {{ $item->user->nama }} - {{ $item->tanggal->format('d F Y') }}')"
                                        class="w-8 h-8 bg-secondary-500 hover:bg-secondary-600 text-white rounded-lg flex items-center justify-center transition-colors mx-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-400 text-xs font-inter">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-inter">
                                {{ $item->lokasiPenempatan->nama_lokasi ?? '-' }}
                                @if ($item->lokasiPenempatan && $item->lokasiPenempatan->jam_masuk)
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->lokasiPenempatan->jam_masuk)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($item->lokasiPenempatan->jam_pulang)->format('H:i') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $statusClass = match ($item->status) {
                                        'masuk' => 'bg-green-100 text-green-800',
                                        'keluar' => 'bg-blue-100 text-blue-800',
                                        'izin' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }} font-inter">
                                    <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <!-- Show Button -->
                                    <a href="{{ route('admin.absensi.show', $item->id) }}"
                                        class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded transition-colors"
                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <button
                                        onclick="deleteAbsensi({{ $item->id }}, '{{ $item->user->nama }}', '{{ $item->tanggal->format('d F Y') }}')"
                                        class="text-red-600 hover:text-red-800 p-1.5 hover:bg-red-50 rounded transition-colors"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                    <p class="font-medium font-inter">Belum ada data absensi</p>
                                    <p class="text-sm font-inter">Data absensi akan muncul ketika karyawan melakukan
                                        presensi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if ($absensi->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($absensi->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                Previous
                            </span>
                        @else
                            <a href="{{ $absensi->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                Previous
                            </a>
                        @endif

                        @if ($absensi->hasMorePages())
                            <a href="{{ $absensi->nextPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                Next
                            </a>
                        @else
                            <span
                                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                Next
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 font-inter">
                                Menampilkan
                                <span class="font-medium">{{ $absensi->firstItem() ?? 0 }}</span>
                                sampai
                                <span class="font-medium">{{ $absensi->lastItem() ?? 0 }}</span>
                                dari
                                <span class="font-medium">{{ $absensi->total() }}</span>
                                hasil
                            </p>
                        </div>
                        <div>
                            {{ $absensi->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-75 items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-4 max-w-2xl w-full shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 id="photoModalTitle" class="text-lg font-poppins font-semibold text-gray-800"></h3>
                <button onclick="closePhotoModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="relative">
                <img id="photoModalImage" src="" alt="Bukti Kehadiran"
                    class="w-full h-auto rounded-lg shadow-lg" />
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="closePhotoModal()"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto submit form on search input (with debounce)
            let searchTimeout;
            const searchInput = document.querySelector('input[name="search"]');
            const lokasiSelect = document.querySelector('#lokasiSelect');
            const filterForm = document.querySelector('#filterForm');

            if (searchInput && filterForm) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        filterForm.submit();
                    }, 500);
                });
            }

            if (lokasiSelect && filterForm) {
                lokasiSelect.addEventListener('change', function() {
                    filterForm.submit();
                });
            }
        });

        function deleteAbsensi(id, nama, tanggal) {
            Swal.fire({
                title: 'Hapus Data Absensi',
                html: `Apakah Anda yakin ingin menghapus data absensi <strong>${nama}</strong> tanggal <strong>${tanggal}</strong>?<br><br><small class="text-gray-500">Data yang dihapus tidak dapat dikembalikan!</small>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/absensi/${id}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Photo modal functions
        function showPhoto(photoPath, title) {
            const modal = document.getElementById('photoModal');
            const image = document.getElementById('photoModalImage');
            const modalTitle = document.getElementById('photoModalTitle');

            // Construct the full URL for the photo
            const photoUrl = `/storage/${photoPath}`;

            image.src = photoUrl;
            modalTitle.textContent = title;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('photoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoModal();
            }
        });
    </script>
@endpush
