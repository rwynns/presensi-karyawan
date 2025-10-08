<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik untuk dashboard
        $totalKaryawan = User::where('role_id', '!=', 1)->count(); // Exclude admin

        // Data hari ini
        $today = Carbon::today();

        // Hitung karyawan yang hadir (sudah absen masuk)
        $hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->count();

        // Hitung karyawan yang izin hari ini (status disetujui)
        // Termasuk izin sakit, cuti, izin masuk terlambat, izin pulang awal
        $izinHariIni = Izin::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->where('status', 'disetujui')
            ->count();

        // Karyawan yang tidak hadir = total - (hadir + izin)
        // Pastikan tidak negatif (bisa terjadi jika ada duplikasi data)
        $tidakHadir = max(0, $totalKaryawan - ($hadirHariIni + $izinHariIni));

        // Statistik tambahan untuk debugging/admin insight
        $totalIzinPending = Izin::where('status', 'pending')->count();
        $absensiLengkap = Absensi::whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->whereNotNull('jam_keluar')
            ->count();

        // Recent activity - ambil presensi terbaru hari ini
        $recentActivity = Absensi::with('user')
            ->whereDate('tanggal', $today)
            ->orderBy('jam_masuk', 'desc')
            ->take(10)
            ->get()
            ->map(function ($absensi) {
                $time = $absensi->jam_keluar
                    ? $absensi->jam_keluar->format('H:i:s')
                    : ($absensi->jam_masuk ? $absensi->jam_masuk->format('H:i:s') : '00:00:00');

                return (object) [
                    'user' => $absensi->user,
                    'type' => $absensi->jam_keluar ? 'keluar' : 'masuk',
                    'created_at' => Carbon::parse($absensi->tanggal->format('Y-m-d') . ' ' . $time),
                ];
            });

        return view('admin.index', compact(
            'totalKaryawan',
            'hadirHariIni',
            'izinHariIni',
            'tidakHadir',
            'totalIzinPending',
            'absensiLengkap',
            'recentActivity'
        ));
    }
}
