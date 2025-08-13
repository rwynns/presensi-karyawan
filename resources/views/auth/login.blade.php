@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white rounded-xl shadow-xl px-8 py-8 border border-secondary-100">
                <div class="text-center mb-8">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-inter font-bold tracking-tight text-secondary-900">Selamat Datang Kembali!</h2>
                    <p class="mt-2 text-sm font-inter text-secondary-600">Silahkan masuk ke akun anda untuk melanjutkan</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium font-inter text-secondary-800 mb-2">Alamat
                            Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" required autocomplete="email"
                                placeholder="Masukkan email anda" value="{{ old('email') }}"
                                class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-4 py-3 text-base font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" />
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password"
                                class="block text-sm font-medium font-inter text-secondary-800 mb-2">Password</label>
                            <div class="text-sm">
                                <a href="#"
                                    class="font-semibold font-inter text-complimentary-600 hover:text-complimentary-700 transition-colors duration-200">Lupa
                                    password?</a>
                            </div>
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                placeholder="Masukkan password anda"
                                class="block w-full rounded-lg bg-secondary-50 border border-secondary-200 px-4 py-3 text-base font-inter text-secondary-900 placeholder:text-secondary-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:bg-white hover:border-secondary-300 @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" />
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center items-center gap-2 rounded-lg bg-gradient-to-r from-primary-600 to-primary-700 px-4 py-3 text-base font-semibold text-white font-inter shadow-lg hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Masuk ke Sistem
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-secondary-200">
                    <p class="text-center text-sm text-secondary-600 font-inter">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}"
                            class="font-semibold text-complimentary-600 hover:text-complimentary-700 transition-colors duration-200 ml-1">Daftar
                            Sebagai Karyawan</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
