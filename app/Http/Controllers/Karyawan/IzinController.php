<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class IzinController extends Controller
{
    /**
     * Display a listing of user's izin requests
     */
    public function index(Request $request)
    {
        $query = Izin::where('user_id', Auth::id())
            ->with(['user', 'approver'])
            ->latest();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_izin')) {
            $query->where('jenis_izin', $request->jenis_izin);
        }

        $izinList = $query->paginate(10);

        // Get statistics
        $total = Izin::where('user_id', Auth::id())->count();
        $pending = Izin::where('user_id', Auth::id())->where('status', 'pending')->count();
        $disetujui = Izin::where('user_id', Auth::id())->where('status', 'disetujui')->count();
        $ditolak = Izin::where('user_id', Auth::id())->where('status', 'ditolak')->count();

        return view('karyawan.izin.index', compact(
            'izinList',
            'total',
            'pending',
            'disetujui',
            'ditolak'
        ));
    }

    /**
     * Show the form for creating a new izin request
     */
    public function create()
    {
        return view('karyawan.izin.create');
    }

    /**
     * Store a newly created izin request
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_izin' => 'required|in:sakit,cuti,keperluan_keluarga,keperluan_pribadi,lainnya',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:1000',
            'dokumen' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120' // Max 5MB
        ], [
            'jenis_izin.required' => 'Jenis izin wajib dipilih.',
            'jenis_izin.in' => 'Jenis izin tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai izin wajib diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini.',
            'tanggal_selesai.required' => 'Tanggal selesai izin wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai.',
            'alasan.required' => 'Alasan izin wajib diisi.',
            'alasan.max' => 'Alasan maksimal 1000 karakter.',
            'dokumen.required' => 'Dokumen pendukung wajib diupload.',
            'dokumen.mimes' => 'Dokumen harus berformat JPG, JPEG, PNG, atau PDF.',
            'dokumen.max' => 'Ukuran dokumen maksimal 5MB.'
        ]);

        // Check for overlapping izin requests
        $existingIzin = Izin::where('user_id', Auth::id())
            ->where('status', '!=', 'ditolak')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($existingIzin) {
            return back()->withErrors(['tanggal_mulai' => 'Anda sudah memiliki pengajuan izin pada rentang tanggal tersebut.'])
                ->withInput();
        }

        // Handle file upload
        $dokumenPath = null;

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $dokumenPath = $file->store('izin-documents', 'public');
        }

        // Create izin request
        Izin::create([
            'user_id' => Auth::id(),
            'jenis_izin' => $request->jenis_izin,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'file_pendukung' => $dokumenPath,
            'status' => 'pending'
        ]);

        return redirect()->route('karyawan.izin.index')
            ->with('success', 'Pengajuan izin berhasil disubmit. Menunggu persetujuan admin.');
    }

    /**
     * Show detailed view of specific izin request
     */
    public function show($id)
    {
        $izin = Izin::where('user_id', Auth::id())
            ->with(['user', 'user.jabatan', 'approver'])
            ->findOrFail($id);

        return view('karyawan.izin.show', compact('izin'));
    }

    /**
     * Cancel izin request (only if status is pending)
     */
    public function destroy($id)
    {
        $izin = Izin::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        // Delete document file if exists
        if ($izin->file_pendukung && Storage::disk('public')->exists($izin->file_pendukung)) {
            Storage::disk('public')->delete($izin->file_pendukung);
        }

        $izin->delete();

        return redirect()->route('karyawan.izin.index')
            ->with('success', 'Pengajuan izin berhasil dibatalkan.');
    }

    /**
     * Download user's own document
     */
    public function downloadDocument($id)
    {
        $izin = Izin::where('user_id', Auth::id())->findOrFail($id);

        if (!$izin->file_pendukung || !Storage::disk('public')->exists($izin->file_pendukung)) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $izin->file_pendukung));
    }
}
