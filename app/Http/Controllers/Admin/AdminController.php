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

        $hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->count();

        $izinHariIni = Izin::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->where('status', 'approved')
            ->count();

        $tidakHadir = $totalKaryawan - ($hadirHariIni + $izinHariIni);

        // Recent activity - ambil presensi terbaru hari ini
        $recentActivity = Absensi::with('user')
            ->whereDate('tanggal', $today)
            ->orderBy('jam_masuk', 'desc')
            ->take(10)
            ->get()
            ->map(function ($absensi) {
                return (object) [
                    'user' => $absensi->user,
                    'type' => $absensi->jam_keluar ? 'keluar' : 'masuk',
                    'created_at' => $absensi->jam_keluar ?
                        Carbon::parse($absensi->tanggal->format('Y-m-d') . ' ' . $absensi->jam_keluar) :
                        Carbon::parse($absensi->tanggal->format('Y-m-d') . ' ' . $absensi->jam_masuk)
                ];
            });

        return view('admin.index', compact(
            'totalKaryawan',
            'hadirHariIni',
            'izinHariIni',
            'tidakHadir',
            'recentActivity'
        ));
    }
}
