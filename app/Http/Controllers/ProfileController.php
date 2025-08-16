<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\LokasiPenempatan;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with(['role', 'jabatanRelation', 'lokasi'])->find(Auth::id());
        $jabatan = Jabatan::all();
        $lokasi = LokasiPenempatan::all();

        return view('profile.index', compact('user', 'jabatan', 'lokasi'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ];

        // Add no_hp if provided
        if ($request->filled('no_hp')) {
            $updateData['no_hp'] = $request->no_hp;
        }

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

        try {
            User::where('id', $user->id)->update($updateData);

            Log::info('Profile updated successfully', [
                'user_id' => $user->id,
                'updated_fields' => array_keys($updateData)
            ]);

            return redirect()->route('profile.index')
                ->with('success', 'Profile berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Profile update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'data' => $updateData
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profile.')
                ->withInput();
        }
    }
}
