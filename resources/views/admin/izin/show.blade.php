@extends('layouts.dashboard')

@section('title', 'Detail Izin')

@section('content')
    <div class="py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.izin.index') }}"
                    class="text-gray-600 hover:text-gray-800 transition-colors p-2 hover:bg-gray-100 rounded-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="font-bold text-2xl">Detail Pengajuan Izin</h1>
            </div>

            @if ($izin->status === 'pending')
                <div class="flex items-center space-x-2">
                    <button onclick="approveIzin({{ $izin->id }}, '{{ $izin->user->nama }}')"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Setujui
                    </button>
                    <button onclick="rejectIzin({{ $izin->id }}, '{{ $izin->user->nama }}')"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        Tolak
                    </button>
                </div>
            @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Karyawan Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 font-inter">Informasi Karyawan</h3>
                <div class="flex items-center space-x-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-semibold text-white font-inter">
                            {{ strtoupper(substr($izin->user->nama, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-medium text-gray-900 font-inter">{{ $izin->user->nama }}</h4>
                        <p class="text-sm text-gray-600 font-inter">{{ $izin->user->email }}</p>
                        @if ($izin->user->jabatanRelation)
                            <p class="text-sm text-gray-600 font-inter">{{ $izin->user->jabatanRelation->nama_jabatan }}
                            </p>
                        @endif
                        @if ($izin->user->lokasi)
                            <p class="text-sm text-gray-600 font-inter">{{ $izin->user->lokasi->nama_lokasi }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Izin Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 font-inter">Detail Pengajuan Izin</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Jenis Izin</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $izin->jenis_izin_label }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Status</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            @if ($izin->status === 'pending')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 font-inter">
                                    <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Pending
                                </span>
                            @elseif ($izin->status === 'disetujui')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 font-inter">
                                    <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Disetujui
                                </span>
                            @elseif ($izin->status === 'ditolak')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 font-inter">
                                    <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Tanggal Mulai</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 font-inter">{{ $izin->tanggal_mulai->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Tanggal Selesai</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 font-inter">{{ $izin->tanggal_selesai->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Durasi</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 font-inter">{{ $izin->durasi }} hari</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Tanggal Pengajuan</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 font-inter">{{ $izin->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Alasan -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Alasan Izin</label>
                    <div class="p-3 bg-gray-50 rounded-md">
                        <p class="text-sm text-gray-900 font-inter">{{ $izin->alasan ?: '-' }}</p>
                    </div>
                </div>

                <!-- Catatan Admin -->
                @if ($izin->catatan_admin)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-inter">Catatan Admin</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 font-inter">{{ $izin->catatan_admin }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- File Pendukung -->
            @if ($izin->file_pendukung)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 font-inter">Dokumen Pendukung</h3>
                    @php
                        $ext = strtolower(pathinfo($izin->file_pendukung, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp

                    @if ($isImage)
                        <div class="space-y-3">
                            <img src="{{ Storage::url($izin->file_pendukung) }}" alt="Dokumen Pendukung"
                                class="w-full h-48 object-cover rounded-lg border border-gray-200" />
                            <a href="{{ Storage::url($izin->file_pendukung) }}" target="_blank"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                Lihat Dokumen
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-sm text-gray-600 mb-4 font-inter">
                                File: {{ basename($izin->file_pendukung) }}
                            </p>
                            <a href="{{ route('admin.izin.download', $izin->id) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Download
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Timeline/Status History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 font-inter">Riwayat Status</h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 font-inter">Pengajuan dibuat</p>
                            <p class="text-xs text-gray-600 font-inter">{{ $izin->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($izin->status === 'disetujui')
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 font-inter">Pengajuan disetujui</p>
                                <p class="text-xs text-gray-600 font-inter">{{ $izin->updated_at->format('d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @elseif ($izin->status === 'ditolak')
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 font-inter">Pengajuan ditolak</p>
                                <p class="text-xs text-gray-600 font-inter">{{ $izin->updated_at->format('d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 font-inter">Menunggu persetujuan</p>
                                <p class="text-xs text-gray-600 font-inter">Status pending</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 font-inter">Aksi</h3>
                <div class="space-y-2">
                    @if ($izin->status === 'pending')
                        <button onclick="approveIzin({{ $izin->id }}, '{{ $izin->user->nama }}')"
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors">
                            Setujui Pengajuan
                        </button>
                        <button onclick="rejectIzin({{ $izin->id }}, '{{ $izin->user->nama }}')"
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors">
                            Tolak Pengajuan
                        </button>
                    @endif
                    <button onclick="deleteIzin({{ $izin->id }}, '{{ $izin->user->nama }}')"
                        class="w-full border border-red-300 hover:bg-red-50 text-red-700 px-4 py-2 rounded-md text-sm font-medium font-inter transition-colors">
                        Hapus Pengajuan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function approveIzin(id, nama) {
            Swal.fire({
                title: 'Setujui Izin',
                html: `Apakah Anda yakin ingin menyetujui pengajuan izin <strong>${nama}</strong>?`,
                input: 'textarea',
                inputLabel: 'Catatan (opsional)',
                inputPlaceholder: 'Tambahkan catatan persetujuan...',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memproses persetujuan izin',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/izin/${id}/approve`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';
                    form.appendChild(methodField);

                    if (result.value) {
                        const catatanInput = document.createElement('input');
                        catatanInput.type = 'hidden';
                        catatanInput.name = 'catatan_admin';
                        catatanInput.value = result.value;
                        form.appendChild(catatanInput);
                    }

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function rejectIzin(id, nama) {
            Swal.fire({
                title: 'Tolak Izin',
                html: `Apakah Anda yakin ingin menolak pengajuan izin <strong>${nama}</strong>?`,
                input: 'textarea',
                inputLabel: 'Alasan penolakan (wajib)',
                inputPlaceholder: 'Tulis alasan penolakan yang jelas...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value || value.trim() === '') {
                        return 'Alasan penolakan wajib diisi!';
                    }
                    if (value.trim().length < 10) {
                        return 'Alasan penolakan minimal 10 karakter!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memproses penolakan izin',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/izin/${id}/reject`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';
                    form.appendChild(methodField);

                    const catatanInput = document.createElement('input');
                    catatanInput.type = 'hidden';
                    catatanInput.name = 'catatan_admin';
                    catatanInput.value = result.value;
                    form.appendChild(catatanInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function deleteIzin(id, nama) {
            Swal.fire({
                title: 'Hapus Pengajuan Izin',
                html: `Apakah Anda yakin ingin menghapus pengajuan izin <strong>${nama}</strong>?<br><br><small class="text-gray-500">Data yang dihapus tidak dapat dikembalikan!</small>`,
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
                    form.action = `/admin/izin/${id}`;

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
    </script>
@endpush
