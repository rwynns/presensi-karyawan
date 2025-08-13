@extends('layouts.auth')
@section('title', 'Dashboard')
@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-xl px-8 py-8 border border-secondary-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-inter font-bold text-secondary-900">Dashboard</h1>
                        <p class="text-secondary-600 mt-1">Selamat datang, {{ Auth::user()->nama }}!</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-inter font-medium transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg p-6 text-white">
                        <h3 class="text-lg font-inter font-semibold mb-2">Informasi Akun</h3>
                        <p class="text-sm opacity-90">{{ Auth::user()->email }}</p>
                    </div>

                    @if (Auth::user()->jabatanRelation)
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
                            <h3 class="text-lg font-inter font-semibold mb-2">Jabatan</h3>
                            <p class="text-sm opacity-90">{{ Auth::user()->jabatanRelation->nama_jabatan }}</p>
                        </div>
                    @endif

                    @if (Auth::user()->lokasi)
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                            <h3 class="text-lg font-inter font-semibold mb-2">Lokasi</h3>
                            <p class="text-sm opacity-90">{{ Auth::user()->lokasi->nama_lokasi }}</p>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-inter font-semibold text-secondary-900 mb-4">Fitur Presensi</h2>
                    <p class="text-secondary-600 mb-4">Sistem presensi karyawan telah berhasil dikonfigurasi. Anda dapat
                        mulai menggunakan fitur-fitur berikut:</p>
                    <ul class="list-disc list-inside text-secondary-600 space-y-2">
                        <li>Presensi masuk dan keluar</li>
                        <li>Pengajuan izin</li>
                        <li>Riwayat absensi</li>
                        <li>Laporan kehadiran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
