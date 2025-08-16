@extends('layouts.main')

@section('title', 'Detail Izin')

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
                            <h1 class="text-2xl font-poppins font-bold text-gray-900 mb-1">Detail Pengajuan Izin</h1>
                            <p class="text-gray-600 font-inter text-sm">Informasi lengkap pengajuan izin Anda</p>
                        </div>
                        <a href="{{ route('karyawan.izin.index') }}"
                            class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-lg px-4 py-2 transition-all duration-200 inline-flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="font-medium">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Status Header Card -->
                <div
                    class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-2xl shadow-black/10 border border-white/20 mb-4">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div class="flex items-start space-x-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10a1 1 0 001 1h8a1 1 0 001-1V11a1 1 0 00-1-1H9a1 1 0 00-1 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-2xl font-poppins font-bold text-gray-900 mb-2">{{ $izin->jenisIzinLabel }}
                                </h2>
                                <div class="flex items-center space-x-2 text-gray-600 font-inter text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Diajukan pada {{ $izin->created_at->format('d F Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-600 font-inter text-sm mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    <span>ID: #{{ str_pad($izin->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            @php
                                $statusConfig = [
                                    'pending' => [
                                        'bg' => 'bg-gradient-to-r from-yellow-500 to-yellow-600',
                                        'icon' => 'clock',
                                        'text' => 'Menunggu',
                                    ],
                                    'disetujui' => [
                                        'bg' => 'bg-gradient-to-r from-green-500 to-green-600',
                                        'icon' => 'check-circle',
                                        'text' => 'Disetujui',
                                    ],
                                    'ditolak' => [
                                        'bg' => 'bg-gradient-to-r from-red-500 to-red-600',
                                        'icon' => 'times-circle',
                                        'text' => 'Ditolak',
                                    ],
                                ];
                                $config = $statusConfig[$izin->status] ?? $statusConfig['pending'];
                            @endphp
                            <div
                                class="inline-flex items-center px-6 py-3 rounded-xl {{ $config['bg'] }} text-white shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($config['icon'] === 'clock')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @elseif($config['icon'] === 'check-circle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @endif
                                </svg>
                                <span class="font-poppins font-semibold text-lg">{{ $config['text'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Main Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Informasi Izin -->
                        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-poppins font-bold text-gray-900">Informasi Izin</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-inter">Jenis Izin</span>
                                        <span
                                            class="font-poppins font-semibold text-gray-900">{{ $izin->jenisIzinLabel }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-inter">Tanggal Mulai</span>
                                        <span
                                            class="font-poppins font-semibold text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d F Y') }}</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-inter">Durasi Izin</span>
                                        <span class="font-poppins font-semibold text-gray-900">{{ $izin->durasi }}
                                            hari</span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                        <span class="text-gray-600 font-inter">Tanggal Selesai</span>
                                        <span
                                            class="font-poppins font-semibold text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alasan Izin -->
                        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-poppins font-bold text-gray-900">Alasan Izin</h3>
                            </div>
                            <div class="p-6 bg-gray-50 rounded-2xl">
                                <p class="text-gray-700 font-inter leading-relaxed">{{ $izin->alasan }}</p>
                            </div>
                        </div>

                        <!-- Dokumen Pendukung -->
                        @if ($izin->dokumen)
                            <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-poppins font-bold text-gray-900">Dokumen Pendukung</h3>
                                </div>
                                <div class="p-6 bg-gray-50 rounded-2xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            @php
                                                $extension = pathinfo($izin->dokumen, PATHINFO_EXTENSION);
                                                $isPdf = strtolower($extension) === 'pdf';
                                            @endphp
                                            <div
                                                class="w-12 h-12 {{ $isPdf ? 'bg-red-100' : 'bg-blue-100' }} rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 {{ $isPdf ? 'text-red-600' : 'text-blue-600' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if ($isPdf)
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                        </path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-poppins font-semibold text-gray-900">
                                                    {{ basename($izin->dokumen) }}</p>
                                                <p class="text-sm text-gray-500 font-inter">{{ strtoupper($extension) }}
                                                    File</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('karyawan.izin.download', $izin->id) }}"
                                            class="group relative overflow-hidden bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl px-6 py-3 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                            </div>
                                            <div class="relative flex items-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span class="font-poppins font-semibold">Download</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column - Status & Details -->
                    <div class="space-y-6">
                        <!-- Timeline Status -->
                        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-poppins font-bold text-gray-900">Timeline</h3>
                            </div>

                            <div class="space-y-4">
                                <!-- Submitted -->
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-poppins font-semibold text-gray-900">Pengajuan Dikirim</p>
                                        <p class="text-sm text-gray-500 font-inter">
                                            {{ $izin->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Status Line -->
                                <div class="ml-5 border-l-2 border-gray-200 h-6"></div>

                                <!-- Processing -->
                                @if ($izin->status !== 'pending')
                                    <div class="flex items-start space-x-4">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 {{ $izin->status === 'disetujui' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 {{ $izin->status === 'disetujui' ? 'text-green-600' : 'text-red-600' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if ($izin->status === 'disetujui')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-poppins font-semibold text-gray-900">
                                                {{ $izin->status === 'disetujui' ? 'Disetujui' : 'Ditolak' }}
                                            </p>
                                            <p class="text-sm text-gray-500 font-inter">
                                                {{ $izin->tanggal_validasi ? \Carbon\Carbon::parse($izin->tanggal_validasi)->format('d F Y, H:i') : '-' }}
                                            </p>
                                            @if ($izin->disetujui_oleh && $izin->approver)
                                                <p class="text-sm text-gray-500 font-inter">oleh
                                                    {{ $izin->approver->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-start space-x-4">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-yellow-600 animate-spin" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-poppins font-semibold text-gray-900">Menunggu Persetujuan</p>
                                            <p class="text-sm text-gray-500 font-inter">Pengajuan sedang ditinjau oleh
                                                admin</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Admin Response -->
                        @if (($izin->status === 'ditolak' || $izin->status === 'disetujui') && $izin->keterangan_admin)
                            <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div
                                        class="w-8 h-8 {{ $izin->status === 'disetujui' ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ $izin->status === 'disetujui' ? 'text-green-600' : 'text-red-600' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-poppins font-bold text-gray-900">
                                        {{ $izin->status === 'disetujui' ? 'Catatan Persetujuan' : 'Alasan Penolakan' }}
                                    </h3>
                                </div>
                                <div
                                    class="p-6 {{ $izin->status === 'disetujui' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }} rounded-2xl">
                                    <p
                                        class="{{ $izin->status === 'disetujui' ? 'text-green-700' : 'text-red-700' }} font-inter leading-relaxed">
                                        {{ $izin->keterangan_admin }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- User Information -->
                        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-poppins font-bold text-gray-900">Informasi Karyawan</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="text-gray-600 font-inter text-sm">Nama Lengkap</span>
                                    <span
                                        class="font-poppins font-semibold text-gray-900 text-sm">{{ $izin->user->name }}</span>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="text-gray-600 font-inter text-sm">Email</span>
                                    <span
                                        class="font-poppins font-semibold text-gray-900 text-sm">{{ $izin->user->email }}</span>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="text-gray-600 font-inter text-sm">Jabatan</span>
                                    <span
                                        class="font-poppins font-semibold text-gray-900 text-sm">{{ $izin->user->jabatan ? $izin->user->jabatan->nama_jabatan : '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        @if ($izin->status === 'pending')
                            <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-lg border border-white/20">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-poppins font-bold text-gray-900">Aksi</h3>
                                </div>
                                <button type="button" onclick="confirmDelete()"
                                    class="w-full group relative overflow-hidden bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl px-6 py-3 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                    </div>
                                    <div class="relative flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        <span class="font-poppins font-semibold">Batalkan Pengajuan</span>
                                    </div>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($izin->status === 'pending')
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
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-poppins font-semibold text-gray-900">Batalkan Pengajuan
                                    Izin</h3>
                                <div class="mt-2">
                                    <p class="text-sm font-inter text-gray-500">
                                        Apakah Anda yakin ingin membatalkan pengajuan izin ini? Tindakan ini tidak dapat
                                        dibatalkan dan data akan dihapus permanen.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gray-50/80 backdrop-blur-md px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-white/20">
                        <form action="{{ route('karyawan.izin.destroy', $izin->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-base font-poppins font-medium text-white focus:outline-none transition-all duration-300 sm:ml-3 sm:w-auto sm:text-sm">
                                Ya, Batalkan
                            </button>
                        </form>
                        <button type="button" onclick="closeModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white/90 text-base font-poppins font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function confirmDelete() {
                document.getElementById('deleteModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById('deleteModal');
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            }
        </script>
    @endif
@endsection
