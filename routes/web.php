<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AktivasiController;
use App\Http\Controllers\Admin\LokasiPenempatanController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

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

        // Placeholder routes - akan dibuat nanti
        Route::get('/karyawan', function () {
            return view('admin.karyawan.index');
        })->name('karyawan.index');
        Route::get('/absensi', function () {
            return view('admin.absensi.index');
        })->name('absensi.index');
        Route::get('/izin', function () {
            return view('admin.izin.index');
        })->name('izin.index');
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
        Route::get('/izin', function () {
            return view('karyawan.izin.index');
        })->name('izin.index');
    });
});
