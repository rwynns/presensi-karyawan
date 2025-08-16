@extends('layouts.main')

@section('title', 'Pengajuan Izin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-500 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-complimentary-400/10 rounded-full blur-xl"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen p-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 mb-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-poppins font-bold text-gray-900 mb-1">Pengajuan Izin Baru</h1>
                            <p class="text-gray-600 font-inter text-sm">Lengkapi formulir di bawah ini untuk mengajukan
                                permohonan izin</p>
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

                <!-- Error Messages -->
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
                                <h3 class="text-sm font-medium text-red-800 mb-2">Terdapat kesalahan pada formulir:</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Form -->
                <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-2xl shadow-black/10 border border-white/20">
                    <form action="{{ route('karyawan.izin.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf

                        <!-- Informasi Izin Section -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-poppins font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Informasi Izin
                                </h3>
                                <p class="text-sm text-gray-600 font-inter mt-1">Pilih jenis izin dan tentukan periode yang
                                    dibutuhkan</p>
                            </div>

                            <!-- Jenis Izin -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 font-poppins mb-2">Jenis Izin</label>
                                <select name="jenis_izin" required
                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200 @error('jenis_izin') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Pilih Jenis Izin</option>
                                    <option value="sakit" {{ old('jenis_izin') == 'sakit' ? 'selected' : '' }}>Sakit
                                    </option>
                                    <option value="cuti" {{ old('jenis_izin') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="keperluan_keluarga"
                                        {{ old('jenis_izin') == 'keperluan_keluarga' ? 'selected' : '' }}>Keperluan Keluarga
                                    </option>
                                    <option value="keperluan_pribadi"
                                        {{ old('jenis_izin') == 'keperluan_pribadi' ? 'selected' : '' }}>Keperluan Pribadi
                                    </option>
                                    <option value="lainnya" {{ old('jenis_izin') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('jenis_izin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Izin -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 font-poppins mb-2">Tanggal
                                        Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200 @error('tanggal_mulai') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                                    @error('tanggal_mulai')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 font-poppins mb-2">Tanggal
                                        Selesai</label>
                                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                        required min="{{ date('Y-m-d') }}"
                                        class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200 @error('tanggal_selesai') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                                    @error('tanggal_selesai')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alasan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 font-poppins mb-2">Alasan Izin</label>
                                <textarea name="alasan" rows="4" required placeholder="Jelaskan alasan pengajuan izin dengan detail..."
                                    class="w-full rounded-xl border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors duration-200 resize-none @error('alasan') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                            </div>
                        </div>

                        <!-- Dokumen Pendukung Section -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-4">
                                <h3 class="text-lg font-poppins font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>
                                    Dokumen Pendukung
                                </h3>
                                <p class="text-sm text-gray-600 font-inter mt-1">Upload dokumen yang mendukung pengajuan
                                    izin Anda</p>
                            </div>

                            <!-- Upload Dokumen -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 font-poppins mb-2">File
                                    Dokumen</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary-400 transition-colors duration-200">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="dokumen"
                                                class="relative cursor-pointer bg-white rounded-lg font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500 transition-colors duration-200">
                                                <span class="font-poppins">Upload dokumen</span>
                                                <input id="dokumen" name="dokumen" type="file" class="sr-only"
                                                    required accept=".jpg,.jpeg,.png,.pdf" onchange="showFileName(this)">
                                            </label>
                                            <p class="pl-1 font-inter">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 font-inter">JPG, JPEG, PNG, PDF maksimal 5MB</p>
                                        <div id="fileName" class="hidden mt-2 text-sm text-green-600 font-medium"></div>
                                    </div>
                                </div>
                                @error('dokumen')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Info Dokumen -->
                                <div class="mt-4 p-4 bg-primary-50 rounded-xl border border-primary-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-primary-800 font-poppins mb-2">Dokumen yang
                                                diperlukan:</p>
                                            <ul class="text-sm text-primary-700 space-y-1 font-inter">
                                                <li>• <strong>Sakit:</strong> Surat keterangan dokter</li>
                                                <li>• <strong>Cuti:</strong> Formulir cuti yang disetujui atasan</li>
                                                <li>• <strong>Keperluan keluarga/pribadi:</strong> Surat keterangan atau
                                                    undangan</li>
                                                <li>• <strong>Lainnya:</strong> Dokumen pendukung yang relevan</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('karyawan.izin.index') }}"
                                class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 text-center font-poppins font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="w-full sm:w-auto group relative overflow-hidden bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl px-8 py-3 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-primary-500/25">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                </div>
                                <div class="relative flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span class="font-poppins font-semibold">Ajukan Izin</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showFileName(input) {
            const fileNameDiv = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
                fileNameDiv.innerHTML = `
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>${fileName} (${fileSize} MB)</span>
                    </div>
                `;
                fileNameDiv.classList.remove('hidden');
            } else {
                fileNameDiv.classList.add('hidden');
            }
        }

        // Update tanggal selesai minimum when tanggal mulai changes
        document.querySelector('input[name="tanggal_mulai"]').addEventListener('change', function() {
            const tanggalSelesaiInput = document.querySelector('input[name="tanggal_selesai"]');
            tanggalSelesaiInput.min = this.value;
            if (tanggalSelesaiInput.value && tanggalSelesaiInput.value < this.value) {
                tanggalSelesaiInput.value = this.value;
            }
        });

        // Enhanced file validation
        document.getElementById('dokumen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

            if (file) {
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    this.value = '';
                    document.getElementById('fileName').classList.add('hidden');
                    return;
                }

                if (!allowedTypes.includes(file.type)) {
                    alert('Tipe file tidak didukung. Hanya JPG, JPEG, PNG, dan PDF yang diperbolehkan.');
                    this.value = '';
                    document.getElementById('fileName').classList.add('hidden');
                    return;
                }
            }
        });
    </script>
@endsection
