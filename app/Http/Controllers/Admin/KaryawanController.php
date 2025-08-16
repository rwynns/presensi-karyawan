<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\LokasiPenempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['jabatanRelation', 'lokasi'])
            ->where('role_id', '!=', 1); // Exclude admin users

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('jabatanRelation', function ($subQ) use ($search) {
                        $subQ->where('nama_jabatan', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan_id', $request->jabatan);
        }

        // Filter by lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi_id', $request->lokasi);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get data for filters
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $lokasis = LokasiPenempatan::orderBy('nama_lokasi')->get();

        return view('admin.kelola-karyawan.index', compact('users', 'jabatans', 'lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $lokasis = LokasiPenempatan::orderBy('nama_lokasi')->get();

        return view('admin.kelola-karyawan.create', compact('jabatans', 'lokasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        try {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'jabatan_id' => $request->jabatan_id,
                'lokasi_id' => $request->lokasi_id,
                'alamat' => $request->alamat,
                'role_id' => 2, // Default role untuk karyawan
                'is_active' => $request->is_active,
            ]);

            return redirect()->route('admin.kelola-karyawan.index')
                ->with('success', "Karyawan {$user->nama} berhasil ditambahkan.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan karyawan.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $kelola_karyawan)
    {
        // Load relationships
        $kelola_karyawan->load(['jabatanRelation', 'lokasi']);

        return view('admin.kelola-karyawan.show', compact('kelola_karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $kelola_karyawan)
    {
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $lokasis = LokasiPenempatan::orderBy('nama_lokasi')->get();

        return view('admin.kelola-karyawan.edit', compact('kelola_karyawan', 'jabatans', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, User $kelola_karyawan)
    {
        try {
            $updateData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'jabatan_id' => $request->jabatan_id,
                'lokasi_id' => $request->lokasi_id,
                'alamat' => $request->alamat,
                'is_active' => $request->is_active,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $kelola_karyawan->update($updateData);

            return redirect()->route('admin.kelola-karyawan.show', $kelola_karyawan)
                ->with('success', "Data karyawan {$kelola_karyawan->nama} berhasil diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data karyawan.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $kelola_karyawan)
    {
        try {
            // Check if user has related data (absensi, izin, etc.)
            // You can add more checks here as needed

            $nama = $kelola_karyawan->nama;
            $kelola_karyawan->delete();

            return redirect()->route('admin.kelola-karyawan.index')
                ->with('success', "Karyawan {$nama} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus karyawan. Pastikan tidak ada data terkait yang masih aktif.');
        }
    }
}
