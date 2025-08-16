<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use App\Models\LokasiPenempatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiAdminController extends Controller
{
    /**
     * Display a listing of absensi records
     */
    public function index(Request $request)
    {
        $query = Absensi::with(['user', 'lokasiPenempatan']);

        // Filter by location only
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_penempatan_id', $request->lokasi_id);
        }

        // Search by user name only
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(10);

        // Get filter options
        $users = User::where('role_id', '!=', 1)->get(['id', 'nama']);
        $lokasi = LokasiPenempatan::all(['id', 'nama_lokasi']);

        return view('admin.absensi.index', compact('absensi', 'users', 'lokasi'));
    }

    /**
     * Show detailed view of specific absensi record
     */
    public function show($id)
    {
        $absensi = Absensi::with(['user', 'lokasiPenempatan'])->findOrFail($id);

        return view('admin.absensi.show', compact('absensi'));
    }

    /**
     * Delete absensi record
     */
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $userName = $absensi->user->nama;
        $tanggal = $absensi->tanggal->format('d F Y');

        $absensi->delete();

        return redirect()->route('admin.absensi.index')
            ->with('success', "Data absensi {$userName} tanggal {$tanggal} berhasil dihapus.");
    }

    /**
     * Export absensi data to Excel/CSV
     */
    public function export(Request $request)
    {
        $query = Absensi::with(['user', 'lokasiPenempatan']);

        // Apply same filters as index (name + location only)
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_penempatan_id', $request->lokasi_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $absensiData = $query->orderBy('tanggal', 'desc')->get();

        // Generate CSV content
        $csvContent = "Nama,Email,Lokasi Penempatan,Tanggal,Jam Masuk,Jam Keluar,Status,Jarak Masuk (m),Jarak Keluar (m),Keterangan\n";

        foreach ($absensiData as $item) {
            $csvContent .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                $item->user->nama ?? '',
                $item->user->email ?? '',
                $item->lokasiPenempatan->nama_lokasi ?? '',
                $item->tanggal->format('d/m/Y'),
                $item->jam_masuk ? $item->jam_masuk->format('H:i:s') : '',
                $item->jam_keluar ? $item->jam_keluar->format('H:i:s') : '',
                ucfirst($item->status),
                $item->jarak_masuk ?? '',
                $item->jarak_keluar ?? '',
                $item->keterangan ?? ''
            );
        }

        $filename = 'data_absensi_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Get monthly statistics
     */
    public function statistics(Request $request)
    {
        $month = $request->get('month', date('Y-m'));
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $stats = [
            'total_hadir' => Absensi::whereBetween('tanggal', [$startDate, $endDate])
                ->whereNotNull('jam_masuk')
                ->count(),
            'total_tepat_waktu' => Absensi::whereBetween('tanggal', [$startDate, $endDate])
                ->whereTime('jam_masuk', '<=', '08:00:00')
                ->count(),
            'total_terlambat' => Absensi::whereBetween('tanggal', [$startDate, $endDate])
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->count(),
            'total_pulang_awal' => Absensi::whereBetween('tanggal', [$startDate, $endDate])
                ->whereTime('jam_keluar', '<', '17:00:00')
                ->whereNotNull('jam_keluar')
                ->count(),
        ];

        return response()->json($stats);
    }
}
