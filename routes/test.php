<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AbsensiController;

// Simple test route
Route::get('/test-absensi', function () {
    if (!Auth::check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    return response()->json([
        'status' => 'OK',
        'user' => Auth::user()->nama,
        'timestamp' => now()
    ]);
})->middleware('auth');

// Test POST route
Route::post('/test-absensi-post', function () {
    if (!Auth::check()) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    return response()->json([
        'status' => 'POST OK',
        'user' => Auth::user()->nama,
        'request_data' => request()->all(),
        'timestamp' => now()
    ]);
})->middleware('auth');
