@extends('layouts.dashboard')

@section('title', 'Tambah Karyawan Baru')

@section('content')
    <div class="py-4">
        <div class="flex items-center space-x-2 mb-6">
            <a href="{{ route('admin.kelola-karyawan.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="font-bold text-2xl">Tambah Karyawan Baru</h1>
        </div>
    </div>

    {{-- Alert Messages --}}
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

    @if ($errors->any())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Terdapat kesalahan pada form:</p>
                    <ul class="mt-2 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-primary-600 px-6 py-4">
            <h2 class="text-white font-semibold font-inter">Informasi Karyawan</h2>
            <p class="text-primary-100 text-sm font-inter mt-1">Masukkan data karyawan dengan lengkap dan benar</p>
        </div>

        <form action="{{ route('admin.kelola-karyawan.store') }}" method="POST" id="karyawanForm" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Nama -->
                <div class="lg:col-span-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama"
                        class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('nama') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                        value="{{ old('nama') }}" placeholder="Masukkan nama lengkap karyawan" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email"
                        class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                        value="{{ old('email') }}" placeholder="contoh@email.com" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="block w-full px-3 py-2 pr-10 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        No. HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_hp" id="no_hp"
                        class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('no_hp') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                        value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan_id" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select name="jabatan_id" id="jabatan_id"
                        class="block w-full px-3 py-2 border rounded-md shadow-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('jabatan_id') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                        required>
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}"
                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                {{ $jabatan->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="lg:col-span-2">
                    <label for="lokasi_id" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Lokasi Penempatan <span class="text-red-500">*</span>
                    </label>
                    <select name="lokasi_id" id="lokasi_id"
                        class="block w-full px-3 py-2 border rounded-md shadow-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('lokasi_id') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                        required>
                        <option value="">Pilih Lokasi Penempatan</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ old('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->nama_lokasi }} - {{ $lokasi->alamat_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi_id')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="lg:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 resize-none {{ $errors->has('alamat') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-500 focus:border-primary-500' }} font-inter"
                        placeholder="Masukkan alamat lengkap karyawan" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600 font-inter">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2 font-inter">
                        Status Akun
                    </label>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active') ? 'checked' : '' }}
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 font-inter">
                            Aktifkan akun karyawan setelah dibuat
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 font-inter">Jika tidak dicentang, karyawan perlu diaktifkan secara
                        manual di halaman aktivasi</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kelola-karyawan.index') }}"
                    class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors font-inter">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Batal
                </a>
                <button type="submit" id="submit-btn"
                    class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-inter">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    Simpan Karyawan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icon
                    const svg = this.querySelector('svg');
                    if (type === 'password') {
                        svg.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        `;
                    } else {
                        svg.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        `;
                    }
                });
            }

            // Form validation
            const form = document.getElementById('karyawanForm');
            const submitBtn = document.getElementById('submit-btn');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const nama = document.getElementById('nama').value;
                    const no_hp = document.getElementById('no_hp').value;
                    const jabatan_id = document.getElementById('jabatan_id').value;
                    const lokasi_id = document.getElementById('lokasi_id').value;
                    const alamat = document.getElementById('alamat').value;

                    // Basic validation
                    if (!nama.trim()) {
                        e.preventDefault();
                        alert('Nama lengkap harus diisi.');
                        document.getElementById('nama').focus();
                        return false;
                    }

                    if (!email.trim()) {
                        e.preventDefault();
                        alert('Email harus diisi.');
                        document.getElementById('email').focus();
                        return false;
                    }

                    // Email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        e.preventDefault();
                        alert('Format email tidak valid.');
                        document.getElementById('email').focus();
                        return false;
                    }

                    if (!password.trim()) {
                        e.preventDefault();
                        alert('Password harus diisi.');
                        document.getElementById('password').focus();
                        return false;
                    }

                    if (password.length < 8) {
                        e.preventDefault();
                        alert('Password minimal 8 karakter.');
                        document.getElementById('password').focus();
                        return false;
                    }

                    if (!no_hp.trim()) {
                        e.preventDefault();
                        alert('No. HP harus diisi.');
                        document.getElementById('no_hp').focus();
                        return false;
                    }

                    if (!jabatan_id) {
                        e.preventDefault();
                        alert('Jabatan harus dipilih.');
                        document.getElementById('jabatan_id').focus();
                        return false;
                    }

                    if (!lokasi_id) {
                        e.preventDefault();
                        alert('Lokasi penempatan harus dipilih.');
                        document.getElementById('lokasi_id').focus();
                        return false;
                    }

                    if (!alamat.trim()) {
                        e.preventDefault();
                        alert('Alamat lengkap harus diisi.');
                        document.getElementById('alamat').focus();
                        return false;
                    }

                    // Show loading state
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = `
                            <svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                                <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
                            </svg>
                            Menyimpan...
                        `;
                        submitBtn.disabled = true;
                    }
                });
            }

            // Format phone number
            const noHpInput = document.getElementById('no_hp');
            if (noHpInput) {
                noHpInput.addEventListener('input', function() {
                    // Remove non-numeric characters
                    let value = this.value.replace(/\D/g, '');

                    // Ensure it starts with 08
                    if (value.length > 0 && !value.startsWith('08')) {
                        if (value.startsWith('8')) {
                            value = '0' + value;
                        } else if (value.startsWith('62')) {
                            value = '0' + value.substring(2);
                        }
                    }

                    this.value = value;
                });
            }
        });
    </script>
@endpush
