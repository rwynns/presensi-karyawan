@extends('layouts.main')
@section('title', 'Riwayat Absen')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-500 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-complimentary-400/10 rounded-full blur-2xl"></div>
        </div>

        <div class="relative z-10 min-h-screen flex items-start justify-center p-4">
            <div class="w-full max-w-6xl">
                <!-- Header -->
                <div
                    class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-2xl shadow-black/10 border border-white/20 mb-6">
                    <div class="flex items-center justify-between flex-col md:flex-row gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-poppins font-bold text-gray-800">Riwayat Absen</h1>
                            <p class="text-sm font-inter text-gray-600">Lihat riwayat kehadiran Anda</p>
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <input id="fromDate" type="date"
                                class="w-full md:w-auto rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 text-sm" />
                            <span class="text-white/80">→</span>
                            <input id="toDate" type="date"
                                class="w-full md:w-auto rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 text-sm" />
                            <button id="filterBtn"
                                class="px-4 py-2 rounded-xl bg-gradient-to-r from-complimentary-500 to-complimentary-600 text-white hover:from-complimentary-600 hover:to-complimentary-700 transition">Filter</button>
                            <button id="resetBtn"
                                class="px-4 py-2 rounded-xl bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 transition">Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Table Card -->
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-2xl p-4 md:p-6 shadow-xl shadow-black/5 border border-white/20">
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-gray-600 font-poppins">
                                            <th class="py-3 px-3">Tanggal</th>
                                            <th class="py-3 px-3">Masuk</th>
                                            <th class="py-3 px-3">Keluar</th>
                                            <th class="py-3 px-3">Bukti Masuk</th>
                                            <th class="py-3 px-3">Bukti Keluar</th>
                                            <th class="py-3 px-3">Lokasi</th>
                                            <th class="py-3 px-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="historyBody" class="divide-y divide-gray-100">
                                        <tr>
                                            <td colspan="5" class="py-6 text-center text-gray-500">Memuat data...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-xs text-gray-500" id="paginationInfo"></div>
                                <div class="flex gap-2">
                                    <button id="prevPage"
                                        class="px-3 py-2 rounded-lg bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">Prev</button>
                                    <button id="nextPage"
                                        class="px-3 py-2 rounded-lg bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="lg:col-span-1 space-y-6">
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-2xl p-6 shadow-xl shadow-black/5 border border-white/20">
                            <h4 class="text-base font-poppins font-semibold text-gray-800 mb-3">Ringkasan</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-xl p-4 bg-gradient-to-br from-primary-500 to-primary-600 text-white">
                                    <p class="text-xs opacity-90">Hari Kerja</p>
                                    <p id="sumDays" class="text-xl font-bold">-</p>
                                </div>
                                <div
                                    class="rounded-xl p-4 bg-gradient-to-br from-secondary-500 to-secondary-600 text-white">
                                    <p class="text-xs opacity-90">Hadir</p>
                                    <p id="sumPresent" class="text-xl font-bold">-</p>
                                </div>
                                <div
                                    class="rounded-xl p-4 bg-gradient-to-br from-complimentary-500 to-complimentary-600 text-white">
                                    <p class="text-xs opacity-90">Tepat Waktu</p>
                                    <p id="sumOnTime" class="text-xl font-bold">-</p>
                                </div>
                                <div class="rounded-xl p-4 bg-gradient-to-br from-orange-500 to-orange-600 text-white">
                                    <p class="text-xs opacity-90">Terlambat</p>
                                    <p id="sumLate" class="text-xl font-bold">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <img id="photoModalImage" src="" alt="Bukti Kehadiran" class="w-full h-auto rounded-lg shadow-lg" />
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="closePhotoModal()"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let page = 1;
        let lastPage = 1;
        const perPage = 10;

        document.addEventListener('DOMContentLoaded', () => {
            loadHistory();
            document.getElementById('filterBtn').addEventListener('click', () => {
                page = 1;
                loadHistory();
            });
            document.getElementById('resetBtn').addEventListener('click', () => {
                document.getElementById('fromDate').value = '';
                document.getElementById('toDate').value = '';
                page = 1;
                loadHistory();
            });
            document.getElementById('prevPage').addEventListener('click', () => {
                if (page > 1) {
                    page--;
                    loadHistory();
                }
            });
            document.getElementById('nextPage').addEventListener('click', () => {
                if (page < lastPage) {
                    page++;
                    loadHistory();
                }
            });
        });

        function loadHistory() {
            const from = document.getElementById('fromDate').value;
            const to = document.getElementById('toDate').value;

            const params = new URLSearchParams();
            params.set('page', page);
            params.set('per_page', perPage);
            if (from) params.set('from', from);
            if (to) params.set('to', to);

            fetch(`/absensi/history?${params.toString()}`, {
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(res => {
                    if (!res.success) return;
                    const body = document.getElementById('historyBody');
                    body.innerHTML = '';

                    if (res.data.length === 0) {
                        body.innerHTML =
                            `<tr><td colspan="7" class="py-6 text-center text-gray-500">Tidak ada data</td></tr>`;
                    }

                    res.data.forEach(item => {
                        const statusBadge = item.status === 'keluar' ? 'bg-blue-100 text-blue-700' :
                            'bg-green-100 text-green-700';
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-white/60';
                        tr.innerHTML = `
                            <td class="py-3 px-3 font-medium text-gray-800">${item.tanggal ?? '-'}</td>
                            <td class="py-3 px-3 text-gray-700">${item.jam_masuk ?? '-'}</td>
                            <td class="py-3 px-3 text-gray-700">${item.jam_keluar ?? '-'}</td>
                            <td class="py-3 px-3 text-center">
                                ${item.foto_masuk ? 
                                    `<button onclick="showPhoto('${item.foto_masuk}', 'Bukti Masuk - ${item.tanggal}')" class="w-8 h-8 bg-primary-500 hover:bg-primary-600 text-white rounded-lg flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>` : 
                                    `<span class="text-gray-400 text-xs">-</span>`
                                }
                            </td>
                            <td class="py-3 px-3 text-center">
                                ${item.foto_keluar ? 
                                    `<button onclick="showPhoto('${item.foto_keluar}', 'Bukti Keluar - ${item.tanggal}')" class="w-8 h-8 bg-secondary-500 hover:bg-secondary-600 text-white rounded-lg flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>` : 
                                    `<span class="text-gray-400 text-xs">-</span>`
                                }
                            </td>
                            <td class="py-3 px-3 text-gray-700">${item.lokasi ?? '-'}</td>
                            <td class="py-3 px-3"><span class="px-2 py-1 rounded-lg text-xs ${statusBadge}">${item.status ?? '-'}</span></td>
                        `;
                        body.appendChild(tr);
                    });

                    // Pagination
                    lastPage = res.meta.last_page;
                    document.getElementById('prevPage').disabled = page <= 1;
                    document.getElementById('nextPage').disabled = page >= lastPage;
                    document.getElementById('paginationInfo').textContent =
                        `Halaman ${res.meta.current_page} dari ${res.meta.last_page} (Total ${res.meta.total})`;

                    // Summary (simple)
                    document.getElementById('sumDays').textContent = res.meta.total;
                    const present = res.data.filter(i => i.jam_masuk).length;
                    document.getElementById('sumPresent').textContent = present;
                    const onTime = res.data.filter(i => i.jam_masuk && i.jam_masuk <= '08:00:00').length;
                    document.getElementById('sumOnTime').textContent = onTime;
                    document.getElementById('sumLate').textContent = present - onTime;
                })
                .catch(err => {
                    const body = document.getElementById('historyBody');
                    body.innerHTML =
                        `<tr><td colspan="7" class="py-6 text-center text-red-500">Gagal memuat data</td></tr>`;
                    console.error(err);
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
@endsection
