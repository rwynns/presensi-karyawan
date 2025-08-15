<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Jabatan::withCount('users');

            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama_jabatan', 'LIKE', "%{$search}%")
                        ->orWhere('kode_jabatan', 'LIKE', "%{$search}%");
                });
            }

            // Get paginated results
            $jabatan = $query->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->withQueryString();

            // Handle AJAX requests
            if ($request->ajax() || $request->has('ajax')) {
                $tableHtml = view('admin.jabatan.partials.table', compact('jabatan'))->render();

                return response()->json([
                    'success' => true,
                    'html' => $tableHtml,
                    'count' => $jabatan->total(),
                    'message' => 'Data berhasil dimuat'
                ]);
            }

            return view('admin.jabatan.index', compact('jabatan'));
        } catch (\Throwable $e) {
            Log::error('JabatanController@index error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'user_id' => Auth::id(),
            ]);

            // Handle AJAX error response
            if ($request->ajax() || $request->has('ajax')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memuat data jabatan.',
                    'error' => app()->environment('local') ? $e->getMessage() : null
                ], 500);
            }

            return view('admin.jabatan.index', ['jabatan' => collect()])
                ->with('error', 'Terjadi kesalahan saat memuat data jabatan.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_jabatan' => 'required|string|max:100|unique:jabatan,nama_jabatan',
                'kode_jabatan' => 'required|string|max:20|unique:jabatan,kode_jabatan',
            ], [
                'nama_jabatan.required' => 'Nama jabatan harus diisi.',
                'nama_jabatan.string' => 'Nama jabatan harus berupa teks.',
                'nama_jabatan.max' => 'Nama jabatan maksimal 100 karakter.',
                'nama_jabatan.unique' => 'Nama jabatan sudah digunakan.',
                'kode_jabatan.required' => 'Kode jabatan harus diisi.',
                'kode_jabatan.string' => 'Kode jabatan harus berupa teks.',
                'kode_jabatan.max' => 'Kode jabatan maksimal 20 karakter.',
                'kode_jabatan.unique' => 'Kode jabatan sudah digunakan.',
            ]);

            // Convert kode_jabatan to uppercase
            $validated['kode_jabatan'] = strtoupper($validated['kode_jabatan']);

            $jabatan = Jabatan::create($validated);

            Log::info('Jabatan created successfully', [
                'jabatan_id' => $jabatan->id,
                'user_id' => Auth::id(),
                'data' => $validated
            ]);

            return redirect()->route('admin.jabatan.index')
                ->with('success', 'Jabatan berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('JabatanController@store error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'user_id' => Auth::id(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan jabatan.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        try {
            $jabatan->load(['users' => function ($query) {
                $query->orderBy('nama', 'asc');
            }]);

            return view('admin.jabatan.show', compact('jabatan'));
        } catch (\Throwable $e) {
            Log::error('JabatanController@show error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'jabatan_id' => $jabatan->id,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('admin.jabatan.index')
                ->with('error', 'Terjadi kesalahan saat memuat detail jabatan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        try {
            $validated = $request->validate([
                'nama_jabatan' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('jabatan', 'nama_jabatan')->ignore($jabatan->id)
                ],
                'kode_jabatan' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('jabatan', 'kode_jabatan')->ignore($jabatan->id)
                ],
            ], [
                'nama_jabatan.required' => 'Nama jabatan harus diisi.',
                'nama_jabatan.string' => 'Nama jabatan harus berupa teks.',
                'nama_jabatan.max' => 'Nama jabatan maksimal 100 karakter.',
                'nama_jabatan.unique' => 'Nama jabatan sudah digunakan.',
                'kode_jabatan.required' => 'Kode jabatan harus diisi.',
                'kode_jabatan.string' => 'Kode jabatan harus berupa teks.',
                'kode_jabatan.max' => 'Kode jabatan maksimal 20 karakter.',
                'kode_jabatan.unique' => 'Kode jabatan sudah digunakan.',
            ]);

            // Convert kode_jabatan to uppercase
            $validated['kode_jabatan'] = strtoupper($validated['kode_jabatan']);

            $oldData = $jabatan->toArray();
            $jabatan->update($validated);

            Log::info('Jabatan updated successfully', [
                'jabatan_id' => $jabatan->id,
                'user_id' => Auth::id(),
                'old_data' => $oldData,
                'new_data' => $validated
            ]);

            return redirect()->route('admin.jabatan.index')
                ->with('success', 'Jabatan berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            Log::error('JabatanController@update error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'jabatan_id' => $jabatan->id,
                'user_id' => Auth::id(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memperbarui jabatan.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        try {
            // Check if jabatan has users
            if ($jabatan->users()->count() > 0) {
                return back()->with('error', 'Jabatan tidak dapat dihapus karena masih memiliki karyawan.');
            }

            $jabatanData = $jabatan->toArray();
            $jabatan->delete();

            Log::info('Jabatan deleted successfully', [
                'jabatan_data' => $jabatanData,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('admin.jabatan.index')
                ->with('success', 'Jabatan berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('JabatanController@destroy error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'jabatan_id' => $jabatan->id,
                'user_id' => Auth::id(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus jabatan.');
        }
    }
}
