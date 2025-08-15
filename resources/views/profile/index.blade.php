@extends('layouts.dashboard')

@section('title', 'Profil Pengguna')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Profil Pengguna</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Pribadi -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]">
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>
                </div>

                <!-- Informasi Kerja -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Kerja</h3>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <input type="text" value="{{ $user->role->nama_role ?? '-' }}" readonly
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 text-gray-500">
                    </div>

                    @if ($user->role_id != 1)
                        <!-- Jabatan (hanya untuk non-admin) -->
                        <div>
                            <label for="jabatan_id" class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <select name="jabatan_id" id="jabatan_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jabatan_id', $user->jabatan_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lokasi Penempatan (hanya untuk non-admin) -->
                        <div>
                            <label for="lokasi_id" class="block text-sm font-medium text-gray-700">Lokasi Penempatan</label>
                            <select name="lokasi_id" id="lokasi_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]">
                                <option value="">Pilih Lokasi</option>
                                @foreach ($lokasi as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('lokasi_id', $user->lokasi_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <!-- Admin - tampilkan read-only -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <input type="text" value="Administrator" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 text-gray-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi Penempatan</label>
                            <input type="text" value="Kantor Pusat" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-50 text-gray-500">
                        </div>
                    @endif

                    <!-- Status Aktivasi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Akun</label>
                        <div class="mt-1">
                            @if ($user->is_active)
                                <span
                                    class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Aktivasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ganti Password</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]"
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#332E60] focus:border-[#332E60]"
                            placeholder="Konfirmasi password baru">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <button type="submit"
                    class="bg-[#332E60] text-white px-6 py-2 rounded-lg hover:bg-[#2A2458] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#332E60] transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi Tambahan -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">ID Pengguna</label>
                <p class="mt-1 text-sm text-gray-900">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>
@endsection
