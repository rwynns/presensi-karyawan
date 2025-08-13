@extends('layouts.auth')
@section('title', 'Register Karyawan')
@section('content')
    <div class="flex min-h-screen flex-col justify-center px-6 py-8 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
            <div class="bg-white rounded-xl shadow-xl px-8 py-6 border border-secondary-100">
                <div class="text-center mb-6">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-inter font-bold tracking-tight text-secondary-900">Registrasi Karyawan Baru
                    </h2>
                    <p class="mt-1 text-sm font-inter text-secondary-600">Lengkapi data berikut untuk mendaftarkan karyawan
                    </p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Row 1: Nama & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium font-inter text-secondary-800 mb-1">Nama
                                Lengkap</label>
                            <div class="relative">
                                <input id="nama" type="text" name="nama" required autocomplete="name"
                                    placeholder="Masukkan nama lengkap" value="{{ old('nama') }}"
                                    class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('nama') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" />
                            </div>
                            @error('nama')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium font-inter text-secondary-800 mb-1">Alamat
                                Email</label>
                            <div class="relative">
                                <input id="email" type="email" name="email" required autocomplete="email"
                                    placeholder="Masukkan alamat email" value="{{ old('email') }}"
                                    class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" />
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 2: Password & Konfirmasi Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium font-inter text-secondary-800 mb-1">Password</label>
                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    placeholder="Masukkan password"
                                    class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" />
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium font-inter text-secondary-800 mb-1">Konfirmasi
                                Password</label>
                            <div class="relative">
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    autocomplete="new-password" placeholder="Ulangi password"
                                    class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300" />
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Jabatan & Lokasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Jabatan -->
                        <div>
                            <label for="jabatan_id"
                                class="block text-sm font-medium font-inter text-secondary-800 mb-1">Jabatan</label>
                            <div class="relative">
                                <select id="jabatan_id" name="jabatan_id" required
                                    class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('jabatan_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatan as $jbt)
                                        <option value="{{ $jbt->id }}"
                                            {{ old('jabatan_id') == $jbt->id ? 'selected' : '' }}>
                                            {{ $jbt->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('jabatan_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi Penempatan -->
                        <div>
                            <label for="lokasi_id"
                                class="block text-sm font-medium font-inter text-secondary-800 mb-1">Lokasi
                                Penempatan</label>
                            <div class="relative">
                                <select id="lokasi_id" name="lokasi_id" required
                                    class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('lokasi_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                    <option value="">Pilih Lokasi Penempatan</option>
                                    @foreach ($lokasi as $lok)
                                        <option value="{{ $lok->id }}"
                                            {{ old('lokasi_id') == $lok->id ? 'selected' : '' }}>
                                            {{ $lok->nama_lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('lokasi_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 4: Alamat (Full Width) -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium font-inter text-secondary-800 mb-1">Alamat
                            Lengkap</label>
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap"
                                class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-3 py-2.5 text-sm font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 resize-none @error('alamat') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('alamat') }}</textarea>
                        </div>
                        @error('alamat')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="flex w-full justify-center items-center gap-2 rounded-lg bg-gradient-to-r from-primary-600 to-primary-700 px-4 py-2.5 text-sm font-semibold text-white font-inter shadow-lg hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            Daftarkan Karyawan
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-4 border-t border-secondary-200">
                    <p class="text-center text-sm text-secondary-600 font-inter">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-complimentary-600 hover:text-complimentary-700 transition-colors duration-200 ml-1">Masuk
                            ke Sistem</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
