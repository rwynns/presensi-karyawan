<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class IzinAdminController extends Controller
{
    /**
     * Display a listing of izin requests
     */
    public function index(Request $request)
    {
        $query = Izin::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_mulai', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_sampai);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search by user name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $izin = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get filter options
        $users = User::where('role_id', '!=', 1)->get(['id', 'nama']);

        return view('admin.izin.index', compact('izin', 'users'));
    }

    /**
     * Show detailed view of specific izin request
     */
    public function show($id)
    {
        $izin = Izin::with('user')->findOrFail($id);

        return view('admin.izin.show', compact('izin'));
    }

    /**
     * Approve izin request
     */
    public function approve(Request $request, $id)
    {
        $izin = Izin::findOrFail($id);

        $izin->update([
            'status' => 'disetujui',
            'keterangan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.izin.show', $id)
            ->with('success', 'Izin berhasil disetujui.');
    }

    /**
     * Reject izin request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ], [
            'catatan_admin.required' => 'Catatan penolakan wajib diisi.'
        ]);

        $izin = Izin::findOrFail($id);

        $izin->update([
            'status' => 'ditolak',
            'keterangan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.izin.show', $id)
            ->with('success', 'Izin berhasil ditolak.');
    }

    /**
     * Delete izin request
     */
    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);
        $userName = $izin->user->nama;

        // Delete document file if exists
        if ($izin->file_pendukung && Storage::disk('public')->exists($izin->file_pendukung)) {
            Storage::disk('public')->delete($izin->file_pendukung);
        }

        $izin->delete();

        return redirect()->route('admin.izin.index')
            ->with('success', "Pengajuan izin {$userName} berhasil dihapus.");
    }

    /**
     * Download document
     */
    public function downloadDocument($id)
    {
        $izin = Izin::findOrFail($id);

        if (!$izin->file_pendukung || !Storage::disk('public')->exists($izin->file_pendukung)) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $izin->file_pendukung));
    }

    /**
     * Export izin data to CSV
     */
    public function export(Request $request)
    {
        $query = Izin::with('user');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_mulai', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_selesai', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $izinData = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV content
        $csvContent = "Nama,Email,Jenis Izin,Tanggal Mulai,Tanggal Selesai,Alasan,Status,Catatan Admin,Tanggal Pengajuan\n";

        foreach ($izinData as $item) {
            $csvContent .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                $item->user->nama ?? '',
                $item->user->email ?? '',
                ucfirst($item->jenis_izin),
                $item->tanggal_mulai->format('d/m/Y'),
                $item->tanggal_selesai->format('d/m/Y'),
                str_replace(["\n", "\r", ","], [" ", " ", ";"], $item->alasan),
                ucfirst($item->status),
                str_replace(["\n", "\r", ","], [" ", " ", ";"], $item->catatan_admin ?? ''),
                $item->created_at->format('d/m/Y H:i:s')
            );
        }

        $filename = 'data_izin_' . now()->timezone(config('app.timezone'))->format('Y-m-d_H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Bulk approve izin requests
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'izin_ids' => 'required|array',
            'izin_ids.*' => 'exists:izin,id'
        ]);

        $izinList = Izin::whereIn('id', $request->izin_ids)
            ->where('status', 'pending')
            ->get();

        $updated = 0;
        foreach ($izinList as $izin) {
            $izin->update([
                'status' => 'disetujui',
                'keterangan_admin' => $request->catatan_admin ?? 'Disetujui secara massal'
            ]);
            $updated++;
        }

        return redirect()->route('admin.izin.index')
            ->with('success', "Berhasil menyetujui {$updated} pengajuan izin.");
    }

    /**
     * Bulk reject izin requests
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'izin_ids' => 'required|array',
            'izin_ids.*' => 'exists:izin,id',
            'catatan_admin' => 'required|string|max:500'
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi untuk aksi massal.'
        ]);

        $izinList = Izin::whereIn('id', $request->izin_ids)
            ->where('status', 'pending')
            ->get();

        $updated = 0;
        foreach ($izinList as $izin) {
            $izin->update([
                'status' => 'ditolak',
                'keterangan_admin' => $request->catatan_admin
            ]);
            $updated++;
        }

        return redirect()->route('admin.izin.index')
            ->with('success', "Berhasil menolak {$updated} pengajuan izin.");
    }
}
