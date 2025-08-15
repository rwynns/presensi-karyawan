@extends('layouts.dashboard')

@section('title', 'Edit Jabatan')

@section('content')
    <div class="main-container min-h-screen bg-gray-50 overflow-y-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-full overflow-visible">
            <!-- Header -->
            <div class="flex items-center space-x-2 mb-6">
                <a href="{{ route('admin.jabatan.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="font-bold text-2xl text-gray-900">Edit Jabatan</h1>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Edit Informasi Jabatan</h2>
                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi jabatan {{ $jabatan->nama_jabatan }}</p>
                </div>

                <form id="jabatanForm" action="{{ route('admin.jabatan.update', $jabatan) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="max-w-2xl space-y-6">
                        <!-- Info Card -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Informasi Jabatan</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Dibuat: {{ $jabatan->created_at->format('d M Y H:i') }}</p>
                                        @if ($jabatan->updated_at != $jabatan->created_at)
                                            <p>Terakhir diupdate: {{ $jabatan->updated_at->format('d M Y H:i') }}</p>
                                        @endif
                                        <p>Jumlah karyawan: {{ $jabatan->users()->count() }} orang</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kode Jabatan -->
                        <div>
                            <label for="kode_jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode_jabatan" id="kode_jabatan"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('kode_jabatan') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                value="{{ old('kode_jabatan', $jabatan->kode_jabatan) }}"
                                placeholder="Contoh: MGR, SPV, STF" maxlength="20" style="text-transform: uppercase;"
                                required>
                            @error('kode_jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-600">Maksimal 20 karakter. Akan diubah menjadi huruf besar
                                otomatis.</p>
                        </div>

                        <!-- Nama Jabatan -->
                        <div>
                            <label for="nama_jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan"
                                class="block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 {{ $errors->has('nama_jabatan') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }}"
                                value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}"
                                placeholder="Contoh: Manager, Supervisor, Staff" maxlength="100" required>
                            @error('nama_jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-600">Maksimal 100 karakter.</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Field dengan tanda <span class="text-red-500 mx-1">*</span> wajib diisi
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.jabatan.index') }}"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <a href="{{ route('admin.jabatan.show', $jabatan) }}"
                                class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-6 py-2 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Lihat Detail
                            </a>
                            <button type="submit" id="submitButton"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span id="submitText">Update Jabatan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jabatanForm');
            const submitButton = document.getElementById('submitButton');
            const submitText = document.getElementById('submitText');
            const kodeJabatanInput = document.getElementById('kode_jabatan');

            // Show error message if any
            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    timer: 5000,
                    showConfirmButton: true,
                    toast: true,
                    position: 'top-end',
                    timerProgressBar: true
                });
            @endif

            // Show validation errors
            @if ($errors->any())
                Swal.fire({
                    title: 'Terdapat Kesalahan!',
                    html: '<div class="text-left"><ul class="list-disc list-inside">' +
                        @foreach ($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                    '</ul></div>',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal2-popup-custom'
                    }
                });
            @endif

            // Auto uppercase kode jabatan
            kodeJabatanInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase();
            });

            // Form submission handling
            form.addEventListener('submit', function(e) {
                // Disable submit button to prevent double submission
                submitButton.disabled = true;
                submitText.textContent = 'Memperbarui...';

                // Add loading spinner
                const spinner = document.createElement('div');
                spinner.className = 'animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2';
                submitButton.insertBefore(spinner, submitText);
            });

            // Real-time validation feedback
            const inputs = form.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    // Clear error state when user starts typing
                    if (this.classList.contains('border-red-500')) {
                        this.classList.remove('border-red-500', 'focus:ring-red-500',
                            'focus:border-red-500');
                        this.classList.add('border-gray-300', 'focus:ring-blue-500',
                            'focus:border-blue-500');

                        // Hide error message
                        const errorMsg = this.parentNode.querySelector('.text-red-600');
                        if (errorMsg) {
                            errorMsg.style.display = 'none';
                        }
                    }
                });
            });

            function validateField(field) {
                const value = field.value.trim();
                let isValid = true;
                let errorMessage = '';

                if (!value) {
                    isValid = false;
                    errorMessage = 'Field ini harus diisi';
                } else if (field.name === 'kode_jabatan' && (value.length < 2 || value.length > 20)) {
                    isValid = false;
                    errorMessage = 'Kode jabatan harus 2-20 karakter';
                } else if (field.name === 'nama_jabatan' && (value.length < 3 || value.length > 100)) {
                    isValid = false;
                    errorMessage = 'Nama jabatan harus 3-100 karakter';
                }

                // Update field styling
                if (!isValid) {
                    field.classList.remove('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
                    field.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');

                    // Show error message
                    let errorElement = field.parentNode.querySelector('.text-red-600');
                    if (!errorElement) {
                        errorElement = document.createElement('p');
                        errorElement.className = 'mt-1 text-sm text-red-600';
                        field.parentNode.appendChild(errorElement);
                    }
                    errorElement.textContent = errorMessage;
                    errorElement.style.display = 'block';
                } else {
                    field.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                    field.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
                }

                return isValid;
            }
        });
    </script>
@endpush
