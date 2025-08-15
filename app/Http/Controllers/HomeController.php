<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request - redirect based on user role
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Cek status aktivasi untuk karyawan
        if ($user->role_id != 1 && !$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda belum diaktivasi oleh admin. Silakan hubungi admin untuk aktivasi akun.');
        }

        // Redirect berdasarkan role
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('karyawan.dashboard');
        }
    }
}
