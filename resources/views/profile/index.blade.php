@extends('layouts.main')
@section('title', 'Profile Karyawan')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-500 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-complimentary-400/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen p-4">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 mb-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-poppins font-bold text-gray-900 mb-1">Profile Pengguna</h1>
                            <p class="text-gray-600 font-inter text-sm">Kelola informasi pribadi dan data akun Anda</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-complimentary-500 to-complimentary-600 rounded-xl flex items-center justify-center shadow-md ring-2 ring-white/20">
                                <span class="text-lg font-semibold text-white font-inter">
                                    {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-gray-900 font-inter">{{ Auth::user()->nama }}</p>
                                <p class="text-sm text-gray-600 font-poppins">{{ Auth::user()->role->nama_role ?? 'User' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-white/20 mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-white/90 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-white/20 mb-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <ul class="text-sm text-red-800 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Profile Form -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Profile Form -->
                    <div class="lg:col-span-2">
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-2xl shadow-black/10 border border-white/20">
                            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PATCH')

                                <!-- Informasi Pribadi -->
                                <div class="space-y-6">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h3 class="text-lg font-poppins font-semibold text-gray-900 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            Informasi Pribadi
                                        </h3>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Nama -->
                                        <div>
                                            <label for="nama"
                                                class="block text-sm font-medium text-gray-700 font-poppins mb-2">Nama
                                                Lengkap</label>
                                            <input type="text" name="nama" id="nama"
                                                value="{{ old('nama', $user->nama) }}"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200"
                                                required>
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700 font-poppins mb-2">Email</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200"
                                                required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Nomor HP -->
                                        <div>
                                            <label for="no_hp"
                                                class="block text-sm font-medium text-gray-700 font-poppins mb-2">Nomor
                                                HP</label>
                                            <input type="tel" name="no_hp" id="no_hp"
                                                value="{{ old('no_hp', $user->no_hp) }}"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200"
                                                placeholder="Contoh: 081234567890">
                                        </div>

                                        <!-- Placeholder untuk keseimbangan layout -->
                                        <div></div>
                                    </div>

                                    <!-- Alamat -->
                                    <div>
                                        <label for="alamat"
                                            class="block text-sm font-medium text-gray-700 font-poppins mb-2">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="3"
                                            class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200"
                                            required>{{ old('alamat', $user->alamat) }}</textarea>
                                    </div>
                                </div>

                                <!-- Informasi Kerja -->
                                @if ($user->role_id != 1)
                                    <div class="space-y-6">
                                        <div class="border-b border-gray-200 pb-4">
                                            <h3 class="text-lg font-poppins font-semibold text-gray-900 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6">
                                                    </path>
                                                </svg>
                                                Informasi Kerja
                                            </h3>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Jabatan -->
                                            <div>
                                                <label for="jabatan_id"
                                                    class="block text-sm font-medium text-gray-700 font-poppins mb-2">Jabatan</label>
                                                <select name="jabatan_id" id="jabatan_id"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200">
                                                    <option value="">Pilih Jabatan</option>
                                                    @foreach ($jabatan as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('jabatan_id', $user->jabatan_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nama_jabatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Lokasi Penempatan -->
                                            <div>
                                                <label for="lokasi_id"
                                                    class="block text-sm font-medium text-gray-700 font-poppins mb-2">Lokasi
                                                    Penempatan</label>
                                                <select name="lokasi_id" id="lokasi_id"
                                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200">
                                                    <option value="">Pilih Lokasi</option>
                                                    @foreach ($lokasi as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('lokasi_id', $user->lokasi_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nama_lokasi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Ganti Password -->
                                <div class="space-y-6">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h3 class="text-lg font-poppins font-semibold text-gray-900 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                            Keamanan Akun
                                        </h3>
                                        <p class="text-sm text-gray-600 font-inter mt-1">Kosongkan jika tidak ingin
                                            mengubah
                                            password</p>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Password Baru -->
                                        <div>
                                            <label for="password"
                                                class="block text-sm font-medium text-gray-700 font-poppins mb-2">Password
                                                Baru</label>
                                            <input type="password" name="password" id="password"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200"
                                                placeholder="Masukkan password baru">
                                        </div>

                                        <!-- Konfirmasi Password -->
                                        <div>
                                            <label for="password_confirmation"
                                                class="block text-sm font-medium text-gray-700 font-poppins mb-2">Konfirmasi
                                                Password</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation"
                                                class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200"
                                                placeholder="Konfirmasi password baru">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-6">
                                    <button type="submit"
                                        class="group relative overflow-hidden bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-2xl px-8 py-3 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-primary-500/25">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                        </div>
                                        <div class="relative flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="font-poppins font-semibold">Simpan Perubahan</span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Profile Info Sidebar -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Status Card -->
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-2xl shadow-black/10 border border-white/20">
                            <h4 class="text-base font-poppins font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status Akun
                            </h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Role</span>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $user->role->nama_role ?? 'User' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Status</span>
                                    @if ($user->is_active)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </div>
                                @if ($user->role_id != 1)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Jabatan</span>
                                        <span class="text-sm text-gray-900">
                                            {{ $user->jabatanRelation->nama_jabatan ?? 'Belum diatur' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Lokasi</span>
                                        <span class="text-sm text-gray-900">
                                            {{ $user->lokasi->nama_lokasi ?? 'Belum diatur' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Account Info Card -->
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-2xl shadow-black/10 border border-white/20">
                            <h4 class="text-base font-poppins font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informasi Akun
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">ID Pengguna</span>
                                    <p class="text-sm text-gray-900 font-mono">
                                        #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Bergabung</span>
                                    <p class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Terakhir Update</span>
                                    <p class="text-sm text-gray-900">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($user->role_id != 1)
                            <!-- Quick Actions -->
                            <div
                                class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-2xl shadow-black/10 border border-white/20">
                                <h4 class="text-base font-poppins font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Aksi Cepat
                                </h4>
                                <div class="space-y-3">
                                    <a href="{{ route('karyawan.dashboard') }}"
                                        class="w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl p-3 transition-all duration-300 transform hover:scale-[1.02] flex items-center space-x-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                        <span class="font-poppins font-medium">Ke Beranda</span>
                                    </a>
                                    <a href="{{ route('karyawan.izin.index') }}"
                                        class="w-full bg-gradient-to-r from-complimentary-500 to-complimentary-600 hover:from-complimentary-600 hover:to-complimentary-700 text-white rounded-xl p-3 transition-all duration-300 transform hover:scale-[1.02] flex items-center space-x-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <span class="font-poppins font-medium">Riwayat Izin</span>
                                    </a>
                                    <a href="{{ route('karyawan.riwayat.index') }}"
                                        class="w-full bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700 text-white rounded-xl p-3 transition-all duration-300 transform hover:scale-[1.02] flex items-center space-x-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-poppins font-medium">Riwayat Absen</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
