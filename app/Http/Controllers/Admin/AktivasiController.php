<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class AktivasiController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validasi input request
            $request->validate([
                'status' => 'nullable|in:all,pending,active',
                'search' => 'nullable|string|max:255'
            ]);

            // Start with basic query untuk role karyawan (role_id = 2)
            $query = User::where('role_id', 2);

            // Apply status filter
            $status = $request->get('status', 'all');
            if ($status && $status !== 'all') {
                if ($status === 'pending') {
                    $query->where('is_active', false);
                } elseif ($status === 'active') {
                    $query->where('is_active', true);
                }
            }

            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");

                    // Only add jabatan search if the relationship exists
                    if (class_exists('App\Models\Jabatan')) {
                        $q->orWhereHas('jabatanRelation', function ($jabatan) use ($search) {
                            $jabatan->where('nama_jabatan', 'LIKE', "%{$search}%");
                        });
                    }
                });
            }

            // Get paginated results with safe eager loading
            $users = $query->with(['role'])
                ->orderBy('is_active', 'ASC') // Pending users first
                ->orderBy('created_at', 'DESC')
                ->paginate(10)
                ->withQueryString(); // Preserve query parameters in pagination

            // Try to load additional relationships safely
            try {
                $users->load(['jabatanRelation', 'lokasi']);
            } catch (\Exception $relationError) {
                Log::warning('Could not load relationships for users', [
                    'error' => $relationError->getMessage()
                ]);
            }

            return view('admin.aktivasi.index', compact('users'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('AktivasiController validation error', [
                'errors' => $e->errors(),
                'request' => $request->all(),
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('AktivasiController@index error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except(['_token']),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Create empty paginator to avoid errors
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                collect(),
                0,
                10,
                1,
                [
                    'path' => request()->url(),
                    'pageName' => 'page',
                    'query' => request()->query() // Preserve query parameters
                ]
            );

            return view('admin.aktivasi.index', compact('users'))
                ->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    }

    public function activate(User $user)
    {
        if ($user->role_id != 2) {
            return redirect()->route('admin.aktivasi.index')
                ->with('error', 'Hanya akun karyawan yang dapat diaktivasi.');
        }

        $user->update(['is_active' => true]);

        return redirect()->route('admin.aktivasi.index')
            ->with('success', 'Akun karyawan ' . $user->nama . ' berhasil diaktivasi.');
    }

    public function reject(User $user)
    {
        if ($user->role_id != 2) {
            return redirect()->route('admin.aktivasi.index')
                ->with('error', 'Hanya akun karyawan yang dapat ditolak.');
        }

        $user->delete();

        return redirect()->route('admin.aktivasi.index')
            ->with('success', 'Akun karyawan berhasil ditolak dan dihapus.');
    }

    public function deactivate(User $user)
    {
        if ($user->role_id != 2) {
            return redirect()->route('admin.aktivasi.index')
                ->with('error', 'Hanya akun karyawan yang dapat dinonaktifkan.');
        }

        $user->update(['is_active' => false]);

        return redirect()->route('admin.aktivasi.index')
            ->with('success', 'Akun karyawan ' . $user->nama . ' berhasil dinonaktifkan.');
    }

    public function delete(User $user)
    {
        if ($user->role_id != 2) {
            return redirect()->route('admin.aktivasi.index')
                ->with('error', 'Hanya akun karyawan yang dapat dihapus.');
        }

        $namaKaryawan = $user->nama;

        // Hapus data terkait karyawan (absensi, izin, dll)
        // Ini akan otomatis terhapus karena foreign key constraints
        $user->delete();

        return redirect()->route('admin.aktivasi.index')
            ->with('success', 'Karyawan ' . $namaKaryawan . ' berhasil dihapus beserta semua data terkaitnya.');
    }
}
