<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\LokasiPenempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    /**
     * Check if user location is within allowed radius
     */
    private function isLocationValid($userLat, $userLon, $officeLat, $officeLon, $radius)
    {
        $distance = $this->calculateDistance($userLat, $userLon, $officeLat, $officeLon);
        return $distance <= $radius;
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * Check user location and return status
     */
    public function checkLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $user = Auth::user();
        $userLat = (float) $request->latitude;
        $userLon = (float) $request->longitude;

        // Get user's assigned location
        $lokasiPenempatan = $user->lokasiPenempatan;

        if (!$lokasiPenempatan) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki lokasi penempatan yang ditentukan.',
                'debug' => [
                    'user_id' => $user->id,
                    'lokasi_id' => $user->lokasi_id
                ]
            ]);
        }

        $officeLat = (float) $lokasiPenempatan->latitude;
        $officeLon = (float) $lokasiPenempatan->longitude;
        $radius = (float) $lokasiPenempatan->radius;

        // Calculate actual distance
        $earthRadius = 6371000;
        $dLat = deg2rad($officeLat - $userLat);
        $dLon = deg2rad($officeLon - $userLon);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($userLat)) * cos(deg2rad($officeLat)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $actualDistance = $earthRadius * $c;

        $isValid = $actualDistance <= $radius;

        if ($isValid) {
            return response()->json([
                'success' => true,
                'message' => 'Lokasi Anda valid untuk melakukan absensi.',
                'location_name' => $lokasiPenempatan->nama_lokasi,
                'distance_info' => 'Anda berada dalam radius yang diizinkan.',
                'debug' => [
                    'user_location' => [$userLat, $userLon],
                    'office_location' => [$officeLat, $officeLon],
                    'distance' => round($actualDistance, 2),
                    'radius' => $radius
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi Anda terlalu jauh dari lokasi penempatan.',
                'location_name' => $lokasiPenempatan->nama_lokasi,
                'distance_info' => 'Jarak Anda: ' . round($actualDistance) . ' meter. Maksimal: ' . $radius . ' meter.',
                'debug' => [
                    'user_location' => [$userLat, $userLon],
                    'office_location' => [$officeLat, $officeLon],
                    'distance' => round($actualDistance, 2),
                    'radius' => $radius
                ]
            ]);
        }
    }

    /**
     * Clock in (absen masuk)
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|string' // data URL base64 image
        ]);

        $user = Auth::user();
        $today = Carbon::today();

        // Check if user already clocked in today
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        if ($existingAbsensi && $existingAbsensi->jam_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen masuk hari ini pada ' . $existingAbsensi->jam_masuk->format('H:i:s')
            ]);
        }

        $userLat = $request->latitude;
        $userLon = $request->longitude;

        // Get user's assigned location
        $lokasiPenempatan = $user->lokasiPenempatan;

        if (!$lokasiPenempatan) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki lokasi penempatan yang ditentukan.'
            ]);
        }

        // Validate location
        $isValid = $this->isLocationValid(
            $userLat,
            $userLon,
            $lokasiPenempatan->latitude,
            $lokasiPenempatan->longitude,
            $lokasiPenempatan->radius
        );

        if (!$isValid) {
            // Calculate distance for error message
            $distance = $this->calculateDistance($userLat, $userLon, $lokasiPenempatan->latitude, $lokasiPenempatan->longitude);

            return response()->json([
                'success' => false,
                'message' => 'Lokasi Anda terlalu jauh dari lokasi penempatan untuk melakukan absensi.',
                'distance_info' => [
                    'distance' => round($distance, 2),
                    'allowed_radius' => $lokasiPenempatan->radius,
                    'unit' => 'meter'
                ]
            ]);
        }

        // Calculate actual distance for recording
        $jarak = $this->calculateDistance($userLat, $userLon, $lokasiPenempatan->latitude, $lokasiPenempatan->longitude);

        // Save photo proof
        $fotoPath = $this->saveAttendancePhoto($request->photo, 'masuk', $user->id);

        // Create or update absensi record
        if ($existingAbsensi) {
            $existingAbsensi->update([
                'jam_masuk' => Carbon::now(),
                'latitude_masuk' => $userLat,
                'longitude_masuk' => $userLon,
                'jarak_masuk' => round($jarak),
                'foto_masuk' => $fotoPath,
                'status' => 'masuk'
            ]);
            $absensi = $existingAbsensi;
        } else {
            $absensi = Absensi::create([
                'user_id' => $user->id,
                'lokasi_penempatan_id' => $lokasiPenempatan->id,
                'tanggal' => $today,
                'jam_masuk' => Carbon::now(),
                'latitude_masuk' => $userLat,
                'longitude_masuk' => $userLon,
                'jarak_masuk' => round($jarak),
                'foto_masuk' => $fotoPath,
                'status' => 'masuk'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Absen masuk berhasil dicatat!',
            'data' => [
                'jam_masuk' => $absensi->jam_masuk->format('H:i:s'),
                'lokasi' => $lokasiPenempatan->nama_lokasi,
                'jarak' => round($jarak, 2) . ' meter',
                'tanggal' => $absensi->tanggal->format('d F Y')
            ]
        ]);
    }

    /**
     * Clock out (absen keluar)
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|string' // data URL base64 image
        ]);

        $user = Auth::user();
        $today = Carbon::today();

        // Check if user has clocked in today
        $absensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        if (!$absensi || !$absensi->jam_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk hari ini.'
            ]);
        }

        if ($absensi->jam_keluar) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen keluar hari ini pada ' . $absensi->jam_keluar->format('H:i:s')
            ]);
        }

        $userLat = $request->latitude;
        $userLon = $request->longitude;

        // Get user's assigned location
        $lokasiPenempatan = $user->lokasiPenempatan;

        // Validate location
        $isValid = $this->isLocationValid(
            $userLat,
            $userLon,
            $lokasiPenempatan->latitude,
            $lokasiPenempatan->longitude,
            $lokasiPenempatan->radius
        );

        if (!$isValid) {
            // Calculate distance for error message
            $distance = $this->calculateDistance($userLat, $userLon, $lokasiPenempatan->latitude, $lokasiPenempatan->longitude);

            return response()->json([
                'success' => false,
                'message' => 'Lokasi Anda terlalu jauh dari lokasi penempatan untuk melakukan absensi.',
                'distance_info' => [
                    'distance' => round($distance, 2),
                    'allowed_radius' => $lokasiPenempatan->radius,
                    'unit' => 'meter'
                ]
            ]);
        }

        // Calculate actual distance for recording
        $jarak = $this->calculateDistance($userLat, $userLon, $lokasiPenempatan->latitude, $lokasiPenempatan->longitude);

        // Save photo proof
        $fotoPath = $this->saveAttendancePhoto($request->photo, 'keluar', $user->id);

        // Update absensi record
        $absensi->update([
            'jam_keluar' => Carbon::now(),
            'latitude_keluar' => $userLat,
            'longitude_keluar' => $userLon,
            'jarak_keluar' => round($jarak),
            'foto_keluar' => $fotoPath,
            'status' => 'keluar'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen keluar berhasil dicatat!',
            'data' => [
                'jam_masuk' => $absensi->jam_masuk->format('H:i:s'),
                'jam_keluar' => $absensi->jam_keluar->format('H:i:s'),
                'lokasi' => $lokasiPenempatan->nama_lokasi,
                'jarak' => round($jarak, 2) . ' meter',
                'tanggal' => $absensi->tanggal->format('d F Y')
            ]
        ]);
    }

    /**
     * Save base64 data URL photo to public storage and return relative path
     */
    private function saveAttendancePhoto(string $dataUrl, string $type, int $userId): string
    {
        // Expected format: data:image/{ext};base64,{data}
        if (!Str::startsWith($dataUrl, 'data:image/')) {
            abort(response()->json([
                'success' => false,
                'message' => 'Format foto tidak valid.'
            ], 422));
        }

        [$header, $encoded] = explode(',', $dataUrl, 2);
        $extension = 'jpg';
        if (Str::contains($header, 'image/png')) {
            $extension = 'png';
        } elseif (Str::contains($header, 'image/jpeg') || Str::contains($header, 'image/jpg')) {
            $extension = 'jpg';
        } elseif (Str::contains($header, 'image/webp')) {
            $extension = 'webp';
        }

        $binary = base64_decode($encoded);
        if ($binary === false) {
            abort(response()->json([
                'success' => false,
                'message' => 'Gagal memproses data foto.'
            ], 422));
        }

        $today = Carbon::now();
        $directory = 'absensi/' . $today->format('Y/m');
        $filename = 'user-' . $userId . '_' . $today->format('Ymd_His') . '_' . $type . '_' . Str::random(6) . '.' . $extension;
        $path = $directory . '/' . $filename;

        Storage::disk('public')->put($path, $binary);

        // Return a public path relative to storage to be used with Storage::url()
        return $path;
    }

    /**
     * Get today's attendance status
     */
    public function getTodayStatus()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $absensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        $status = [
            'has_clocked_in' => false,
            'has_clocked_out' => false,
            'jam_masuk' => null,
            'jam_keluar' => null,
            'lokasi_penempatan' => $user->lokasiPenempatan ? $user->lokasiPenempatan->nama_lokasi : null
        ];

        if ($absensi) {
            $status['has_clocked_in'] = !is_null($absensi->jam_masuk);
            $status['has_clocked_out'] = !is_null($absensi->jam_keluar);
            $status['jam_masuk'] = $absensi->jam_masuk ? $absensi->jam_masuk->format('H:i:s') : null;
            $status['jam_keluar'] = $absensi->jam_keluar ? $absensi->jam_keluar->format('H:i:s') : null;
        }

        return response()->json([
            'success' => true,
            'data' => $status
        ]);
    }

    /**
     * Debug location - tambahkan method ini
     */
    public function debugLocation(Request $request)
    {
        $user = Auth::user();
        $lokasiPenempatan = $user->lokasiPenempatan;

        $debug = [
            'user_info' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'lokasi_id' => $user->lokasi_id
            ],
            'lokasi_penempatan' => $lokasiPenempatan ? [
                'id' => $lokasiPenempatan->id,
                'nama_lokasi' => $lokasiPenempatan->nama_lokasi,
                'latitude' => $lokasiPenempatan->latitude,
                'longitude' => $lokasiPenempatan->longitude,
                'radius' => $lokasiPenempatan->radius,
                'alamat' => $lokasiPenempatan->alamat
            ] : null,
            'browser_location' => $request->has('latitude') ? [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'accuracy' => $request->accuracy ?? 'unknown'
            ] : null
        ];

        if ($request->has('latitude') && $lokasiPenempatan) {
            $userLat = (float) $request->latitude;
            $userLon = (float) $request->longitude;
            $officeLat = (float) $lokasiPenempatan->latitude;
            $officeLon = (float) $lokasiPenempatan->longitude;

            // Calculate distance
            $earthRadius = 6371000;
            $dLat = deg2rad($officeLat - $userLat);
            $dLon = deg2rad($officeLon - $userLon);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($userLat)) * cos(deg2rad($officeLat)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c;

            $debug['distance_calculation'] = [
                'distance_meters' => round($distance, 2),
                'allowed_radius' => $lokasiPenempatan->radius,
                'is_valid' => $distance <= $lokasiPenempatan->radius,
                'google_maps_link' => "https://www.google.com/maps?q={$userLat},{$userLon}",
                'office_maps_link' => "https://www.google.com/maps?q={$officeLat},{$officeLon}"
            ];
        }

        return response()->json($debug);
    }

    /**
     * Get paginated attendance history for logged-in user
     */
    public function getHistory(Request $request)
    {
        $user = Auth::user();

        $query = Absensi::with('lokasiPenempatan')
            ->where('user_id', $user->id);

        $from = $request->get('from');
        $to = $request->get('to');
        $month = $request->get('month');
        $year = $request->get('year');

        if ($from && $to) {
            try {
                $fromDate = Carbon::parse($from)->startOfDay();
                $toDate = Carbon::parse($to)->endOfDay();
                $query->whereBetween('tanggal', [$fromDate, $toDate]);
            } catch (\Exception $e) {
            }
        } elseif ($month && $year) {
            $query->whereYear('tanggal', (int) $year)
                ->whereMonth('tanggal', (int) $month);
        } else {
            $query->where('tanggal', '>=', Carbon::today()->subDays(30));
        }

        $perPage = (int) ($request->get('per_page', 10));
        $perPage = max(5, min($perPage, 50));

        $paginator = $query->orderBy('tanggal', 'desc')->orderBy('jam_masuk', 'asc')->paginate($perPage);

        $items = $paginator->getCollection()->map(function ($absensi) {
            return [
                'id' => $absensi->id,
                'tanggal' => $absensi->tanggal ? $absensi->tanggal->format('d F Y') : null,
                'jam_masuk' => $absensi->jam_masuk ? $absensi->jam_masuk->format('H:i:s') : null,
                'jam_keluar' => $absensi->jam_keluar ? $absensi->jam_keluar->format('H:i:s') : null,
                'status' => $absensi->status,
                'lokasi' => $absensi->lokasiPenempatan ? $absensi->lokasiPenempatan->nama_lokasi : null,
                'jarak_masuk' => $absensi->jarak_masuk,
                'jarak_keluar' => $absensi->jarak_keluar,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ]
        ]);
    }
}
