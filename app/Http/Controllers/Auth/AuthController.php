<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\LokasiPenempatan;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the register form.
     */
    public function showRegisterForm()
    {
        $jabatan = Jabatan::all();
        $lokasi = LokasiPenempatan::all();

        return view('auth.register', compact('jabatan', 'lokasi'));
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek apakah akun sudah aktif (untuk karyawan)
            if ($user->role_id != 1 && !$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum diaktivasi oleh admin. Silakan hubungi admin untuk aktivasi akun.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Record login history if needed
            // You can add login history logging here

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle register request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jabatan_id' => ['required', 'exists:jabatan,id'],
            'lokasi_id' => ['required', 'exists:lokasi_penempatan,id'],
            'alamat' => ['required', 'string'],
        ]);

        // Get default role (you might want to set a default role for employees)
        $defaultRole = Role::where('nama_role', 'Karyawan')->first();

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan_id' => $request->jabatan_id,
            'lokasi_id' => $request->lokasi_id,
            'alamat' => $request->alamat,
            'role_id' => $defaultRole ? $defaultRole->id : 2, // Default ke role_id = 2 (Karyawan)
            'is_active' => false, // Akun tidak aktif secara default, harus disetujui admin
        ]);

        // Redirect ke login dengan pesan informasi
        return redirect('/login')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin. Silakan hubungi admin untuk aktivasi akun.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
