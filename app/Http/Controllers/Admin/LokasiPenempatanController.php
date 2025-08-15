<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiPenempatan;
use App\Services\MapServiceFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LokasiPenempatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = LokasiPenempatan::query();

            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lokasi', 'LIKE', "%{$search}%")
                        ->orWhere('alamat_lengkap', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // Get paginated results
            $lokasi = $query->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->withQueryString();

            return view('admin.lokasi-penempatan.index', compact('lokasi'));
        } catch (\Throwable $e) {
            Log::error('LokasiPenempatanController@index error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'user_id' => Auth::id(),
            ]);

            return view('admin.lokasi-penempatan.index', ['lokasi' => collect()])
                ->with('error', 'Terjadi kesalahan saat memuat data lokasi penempatan.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Temporary fix - use Google Maps view directly
        return view('admin.lokasi-penempatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_lokasi' => 'required|string|max:100',
                'alamat_lengkap' => 'required|string|max:1000',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'radius' => 'required|integer|min:10|max:1000',
                'description' => 'nullable|string|max:1000',
            ], [
                'nama_lokasi.required' => 'Nama lokasi wajib diisi',
                'nama_lokasi.max' => 'Nama lokasi maksimal 100 karakter',
                'alamat_lengkap.required' => 'Alamat lengkap wajib diisi',
                'alamat_lengkap.max' => 'Alamat lengkap maksimal 1000 karakter',
                'latitude.required' => 'Koordinat latitude wajib diisi',
                'latitude.numeric' => 'Latitude harus berupa angka',
                'latitude.between' => 'Latitude harus antara -90 sampai 90',
                'longitude.required' => 'Koordinat longitude wajib diisi',
                'longitude.numeric' => 'Longitude harus berupa angka',
                'longitude.between' => 'Longitude harus antara -180 sampai 180',
                'radius.required' => 'Radius wajib diisi',
                'radius.integer' => 'Radius harus berupa angka bulat',
                'radius.min' => 'Radius minimal 10 meter',
                'radius.max' => 'Radius maksimal 1000 meter',
                'description.max' => 'Deskripsi maksimal 1000 karakter',
            ]);

            LokasiPenempatan::create($validated);

            return redirect()->route('admin.lokasi-penempatan.index')
                ->with('success', 'Lokasi penempatan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('LokasiPenempatanController@store error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data lokasi penempatan.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LokasiPenempatan $lokasiPenempatan)
    {
        return view('admin.lokasi-penempatan.show', compact('lokasiPenempatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LokasiPenempatan $lokasiPenempatan)
    {
        return view('admin.lokasi-penempatan.edit', compact('lokasiPenempatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LokasiPenempatan $lokasiPenempatan)
    {
        try {
            $validated = $request->validate([
                'nama_lokasi' => 'required|string|max:100',
                'alamat_lengkap' => 'required|string|max:1000',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'radius' => 'required|integer|min:10|max:1000',
                'description' => 'nullable|string|max:1000',
            ], [
                'nama_lokasi.required' => 'Nama lokasi wajib diisi',
                'nama_lokasi.max' => 'Nama lokasi maksimal 100 karakter',
                'alamat_lengkap.required' => 'Alamat lengkap wajib diisi',
                'alamat_lengkap.max' => 'Alamat lengkap maksimal 1000 karakter',
                'latitude.required' => 'Koordinat latitude wajib diisi',
                'latitude.numeric' => 'Latitude harus berupa angka',
                'latitude.between' => 'Latitude harus antara -90 sampai 90',
                'longitude.required' => 'Koordinat longitude wajib diisi',
                'longitude.numeric' => 'Longitude harus berupa angka',
                'longitude.between' => 'Longitude harus antara -180 sampai 180',
                'radius.required' => 'Radius wajib diisi',
                'radius.integer' => 'Radius harus berupa angka bulat',
                'radius.min' => 'Radius minimal 10 meter',
                'radius.max' => 'Radius maksimal 1000 meter',
                'description.max' => 'Deskripsi maksimal 1000 karakter',
            ]);

            $lokasiPenempatan->update($validated);

            return redirect()->route('admin.lokasi-penempatan.index')
                ->with('success', 'Lokasi penempatan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('LokasiPenempatanController@update error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data lokasi penempatan.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LokasiPenempatan $lokasiPenempatan)
    {
        try {
            $namaLokasi = $lokasiPenempatan->nama_lokasi;

            // Check if location is still being used by employees
            if ($lokasiPenempatan->users()->exists()) {
                return redirect()->route('admin.lokasi-penempatan.index')
                    ->with('error', 'Tidak dapat menghapus lokasi ' . $namaLokasi . ' karena masih digunakan oleh karyawan.');
            }

            $lokasiPenempatan->delete();

            return redirect()->route('admin.lokasi-penempatan.index')
                ->with('success', 'Lokasi penempatan ' . $namaLokasi . ' berhasil dihapus');
        } catch (\Throwable $e) {
            Log::error('LokasiPenempatanController@destroy error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'lokasi_id' => $lokasiPenempatan->id,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('admin.lokasi-penempatan.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data lokasi penempatan.');
        }
    }
}
