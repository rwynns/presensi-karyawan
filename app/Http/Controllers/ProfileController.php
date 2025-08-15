<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\LokasiPenempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jabatan = Jabatan::all();
        $lokasi = LokasiPenempatan::all();

        return view('profile.index', compact('user', 'jabatan', 'lokasi'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'jabatan_id' => ['nullable', 'exists:jabatan,id'],
            'lokasi_id' => ['nullable', 'exists:lokasi_penempatan,id'],
            'alamat' => ['required', 'string'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ];

        // Only update jabatan_id and lokasi_id for non-admin users
        if ($user->role_id != 1) {
            if ($request->jabatan_id) {
                $updateData['jabatan_id'] = $request->jabatan_id;
            }
            if ($request->lokasi_id) {
                $updateData['lokasi_id'] = $request->lokasi_id;
            }
        }

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($updateData);

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
