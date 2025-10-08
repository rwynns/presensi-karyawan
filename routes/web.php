<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AktivasiController;
use App\Http\Controllers\Admin\LokasiPenempatanController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\AbsensiAdminController;
use App\Http\Controllers\Admin\IzinAdminController;
use App\Http\Controllers\Karyawan\IzinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsensiController;

// Home route - requires authentication
Route::get('/', HomeController::class)->middleware('auth')->name('home');

// Authentication Routes - Only for guests
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('karyawan.dashboard');
        }
    })->name('dashboard');

    // Profile Routes - Available to all authenticated users
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin Routes
    Route::middleware(['check.role:1'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Aktivasi Akun Routes
        Route::get('/aktivasi', [AktivasiController::class, 'index'])->name('aktivasi.index');
        Route::patch('/aktivasi/{user}/activate', [AktivasiController::class, 'activate'])->name('aktivasi.activate');
        Route::delete('/aktivasi/{user}/reject', [AktivasiController::class, 'reject'])->name('aktivasi.reject');
        Route::patch('/aktivasi/{user}/deactivate', [AktivasiController::class, 'deactivate'])->name('aktivasi.deactivate');
        Route::delete('/aktivasi/{user}/delete', [AktivasiController::class, 'delete'])->name('aktivasi.delete');

        // Lokasi Penempatan Routes
        Route::resource('lokasi-penempatan', LokasiPenempatanController::class);

        // Jabatan Routes
        Route::resource('jabatan', JabatanController::class);

        // Kelola Karyawan Routes
        Route::resource('kelola-karyawan', KaryawanController::class);

        // Absensi Routes
        Route::get('/absensi', [AbsensiAdminController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/{id}', [AbsensiAdminController::class, 'show'])->name('absensi.show');
        Route::delete('/absensi/{id}', [AbsensiAdminController::class, 'destroy'])->name('absensi.destroy');
        Route::get('/absensi-export', [AbsensiAdminController::class, 'export'])->name('absensi.export');

        // Izin Routes
        Route::get('/izin', [IzinAdminController::class, 'index'])->name('izin.index');
        Route::get('/izin/{id}', [IzinAdminController::class, 'show'])->name('izin.show');
        Route::patch('/izin/{id}/approve', [IzinAdminController::class, 'approve'])->name('izin.approve');
        Route::patch('/izin/{id}/reject', [IzinAdminController::class, 'reject'])->name('izin.reject');
        Route::delete('/izin/{id}', [IzinAdminController::class, 'destroy'])->name('izin.destroy');
        Route::get('/izin/{id}/download', [IzinAdminController::class, 'downloadDocument'])->name('izin.download');
        Route::get('/izin-export', [IzinAdminController::class, 'export'])->name('izin.export');
        Route::patch('/izin/bulk-approve', [IzinAdminController::class, 'bulkApprove'])->name('izin.bulk-approve');
        Route::patch('/izin/bulk-reject', [IzinAdminController::class, 'bulkReject'])->name('izin.bulk-reject');

        // Placeholder routes - akan dibuat nanti
        Route::get('/karyawan', function () {
            return view('admin.karyawan.index');
        })->name('karyawan.index');
        Route::get('/lokasi', function () {
            return view('admin.lokasi.index');
        })->name('lokasi.index');
        Route::get('/laporan', function () {
            return view('admin.laporan.index');
        })->name('laporan.index');
        Route::get('/settings', function () {
            return view('admin.settings.index');
        })->name('settings.index');
    });

    // Karyawan Routes
    Route::middleware(['check.role:2,3'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/', function () {
            return view('index');
        })->name('dashboard');
        Route::get('/presensi', function () {
            return view('karyawan.presensi.index');
        })->name('presensi.index');
        Route::get('/riwayat', function () {
            return view('karyawan.riwayat.index');
        })->name('riwayat.index');

        // Izin Routes for Karyawan
        Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
        Route::get('/izin/create', [IzinController::class, 'create'])->name('izin.create');
        Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');
        Route::get('/izin/{id}', [IzinController::class, 'show'])->name('izin.show');
        Route::delete('/izin/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');
        Route::get('/izin/{id}/download', [IzinController::class, 'downloadDocument'])->name('izin.download');
    });

    // Absensi Routes (accessible by all authenticated users)
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::post('/check-location', [AbsensiController::class, 'checkLocation'])->name('check-location');
        Route::post('/clock-in', [AbsensiController::class, 'clockIn'])->name('clock-in');
        Route::post('/clock-out', [AbsensiController::class, 'clockOut'])->name('clock-out');
        Route::get('/status', [AbsensiController::class, 'getTodayStatus'])->name('status');
        Route::get('/history', [AbsensiController::class, 'getHistory'])->name('history');
        Route::post('/auto-clockout-early', [AbsensiController::class, 'autoClockOutEarlyDeparture'])->name('auto-clockout-early');
    });

    // Debug routes
    Route::get('/debug-location', [AbsensiController::class, 'debugLocation']);
    Route::post('/debug-location', [AbsensiController::class, 'debugLocation']);

    // Test routes for debugging
    Route::get('/test-absensi', function () {
        return response()->json([
            'status' => 'OK',
            'user' => Auth::user()->nama,
            'timestamp' => now(),
            'csrf_token' => csrf_token()
        ]);
    });

    Route::post('/test-absensi-post', function () {
        return response()->json([
            'status' => 'POST OK',
            'user' => Auth::user()->nama,
            'request_data' => request()->all(),
            'timestamp' => now()
        ]);
    });

    // Debug route untuk cek user dan role
    Route::get('/debug-user', function () {
        $user = Auth::user();
        return response()->json([
            'user_id' => $user->id,
            'nama' => $user->nama,
            'role_id' => $user->role_id,
            'role_name' => $user->role->nama_role ?? 'No role',
            'is_active' => $user->is_active,
            'can_access_karyawan_routes' => in_array($user->role_id, [2, 3]),
            'izin_index_url' => route('karyawan.izin.index')
        ]);
    });
});
