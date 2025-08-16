@extends('layouts.main')

@section('title', 'Riwayat Izin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-500 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-complimentary-400/10 rounded-full blur-xl"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen p-4">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 mb-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-poppins font-bold text-gray-900 mb-1">Riwayat Izin</h1>
                            <p class="text-gray-600 font-inter text-sm">Kelola dan pantau status pengajuan izin Anda</p>
                        </div>
                        <a href="{{ route('karyawan.izin.create') }}"
                            class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-lg px-4 py-2 transition-all duration-200 inline-flex items-center text-sm">
                            <i class="fas fa-plus mr-2"></i>
                            <span class="font-medium">Ajukan Izin</span>
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-white/20 mb-4">
                    <form method="GET" action="{{ route('karyawan.izin.index') }}" class="flex flex-wrap items-end gap-3">
                        <div class="flex-1 min-w-40">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 text-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-40">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jenis Izin</label>
                            <select name="jenis_izin"
                                class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 text-sm">
                                <option value="">Semua Jenis</option>
                                <option value="sakit" {{ request('jenis_izin') == 'sakit' ? 'selected' : '' }}>Sakit
                                </option>
                                <option value="cuti" {{ request('jenis_izin') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="keperluan_keluarga"
                                    {{ request('jenis_izin') == 'keperluan_keluarga' ? 'selected' : '' }}>Keperluan Keluarga
                                </option>
                                <option value="keperluan_pribadi"
                                    {{ request('jenis_izin') == 'keperluan_pribadi' ? 'selected' : '' }}>Keperluan Pribadi
                                </option>
                                <option value="lainnya" {{ request('jenis_izin') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors text-sm">
                                <i class="fas fa-search mr-1"></i>Filter
                            </button>
                            <a href="{{ route('karyawan.izin.index') }}"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors text-sm">
                                <i class="fas fa-times mr-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                    <div class="bg-white/90 backdrop-blur-md rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-primary-500 rounded-lg">
                                <i class="fas fa-calendar-alt text-white text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xl font-bold text-gray-900">{{ $total }}</p>
                                <p class="text-gray-600 text-xs">Total Izin</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-md rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-500 rounded-lg">
                                <i class="fas fa-clock text-white text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xl font-bold text-gray-900">{{ $pending }}</p>
                                <p class="text-gray-600 text-xs">Menunggu</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-md rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-500 rounded-lg">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xl font-bold text-gray-900">{{ $disetujui }}</p>
                                <p class="text-gray-600 text-xs">Disetujui</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-md rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-500 rounded-lg">
                                <i class="fas fa-times-circle text-white text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xl font-bold text-gray-900">{{ $ditolak }}</p>
                                <p class="text-gray-600 text-xs">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Izin Table -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                    @if ($izinList->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50/80">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis & Periode
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Alasan
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dokumen
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/70 divide-y divide-gray-200">
                                    @foreach ($izinList as $izin)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $izin->created_at->format('d/m/Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $izin->created_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $izin->jenisIzinLabel }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }} -
                                                    {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    ({{ $izin->durasi }} hari)
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-gray-900 max-w-xs">
                                                    {{ Str::limit($izin->alasan, 50) }}
                                                    @if (strlen($izin->alasan) > 50)
                                                        <button type="button"
                                                            onclick="showFullReason('{{ $izin->id }}')"
                                                            class="text-primary-600 hover:text-primary-800 ml-1 text-xs">
                                                            ...
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    {{ $izin->status == 'disetujui'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($izin->status == 'ditolak'
                                                            ? 'bg-red-100 text-red-800'
                                                            : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($izin->status) }}
                                                </span>
                                                @if ($izin->status !== 'pending')
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $izin->updated_at->format('d/m/Y') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($izin->dokumen)
                                                    <a href="{{ route('karyawan.izin.download', $izin->id) }}"
                                                        class="text-primary-600 hover:text-primary-800 text-xs">
                                                        <i class="fas fa-download mr-1"></i>
                                                        Download
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('karyawan.izin.show', $izin->id) }}"
                                                        class="text-primary-600 hover:text-primary-800"
                                                        title="Lihat Detail">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </a>
                                                    @if ($izin->status === 'pending')
                                                        <button type="button"
                                                            onclick="confirmDelete('{{ $izin->id }}')"
                                                            class="text-red-600 hover:text-red-800" title="Hapus">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($izinList->hasPages())
                            <div class="px-4 py-3 border-t border-gray-200 bg-white/50">
                                {{ $izinList->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="p-8 text-center">
                            <div class="max-w-sm mx-auto">
                                <div class="mb-4">
                                    <i class="fas fa-calendar-times text-4xl text-gray-300"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengajuan Izin</h3>
                                <p class="text-gray-500 text-sm mb-4">Anda belum mengajukan izin apapun</p>
                                <a href="{{ route('karyawan.izin.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors text-sm">
                                    <i class="fas fa-plus mr-2"></i>Ajukan Izin Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white/95 backdrop-blur-md rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/20">
                    <div class="bg-white/95 px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <h3 class="text-xl font-poppins font-semibold text-gray-900 mb-4">Detail Pengajuan Izin</h3>
                        <div id="detailContent">
                            <!-- Content will be loaded here -->
                        </div>
                    </div>
                    <div
                        class="bg-gray-50/80 backdrop-blur-md px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-white/20">
                        <button type="button" onclick="closeModal('detailModal')"
                            class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white/90 text-base font-poppins font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white/95 backdrop-blur-md rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/20">
                    <div class="bg-white/95 px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-r from-red-500 to-red-600 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-poppins font-semibold text-gray-900">Hapus Pengajuan Izin
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm font-inter text-gray-500">
                                        Apakah Anda yakin ingin menghapus pengajuan izin ini? Tindakan ini tidak dapat
                                        dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gray-50/80 backdrop-blur-md px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-white/20">
                        <form id="deleteForm" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-base font-poppins font-medium text-white focus:outline-none transition-all duration-300 sm:ml-3 sm:w-auto sm:text-sm">
                                Hapus
                            </button>
                        </form>
                        <button type="button" onclick="closeModal('deleteModal')"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white/90 text-base font-poppins font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showDetail(izinId) {
                // In a real application, you would fetch detailed data via AJAX
                // For now, we'll use the data already available in the table
                const modal = document.getElementById('detailModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function showFullReason(izinId) {
                // Implementation to show full reason text
                // This could be done via AJAX or by storing full text in data attributes
                const modal = document.getElementById('detailModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function confirmDelete(izinId) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/karyawan/izin/${izinId}`;
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                const detailModal = document.getElementById('detailModal');
                const deleteModal = document.getElementById('deleteModal');
                if (event.target === detailModal) {
                    detailModal.classList.add('hidden');
                    detailModal.classList.remove('flex');
                }
                if (event.target === deleteModal) {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                }
            }
        </script>
    @endsection
