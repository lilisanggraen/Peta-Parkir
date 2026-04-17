<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\ParkingSpotController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// ============================================================
// HALAMAN PUBLIK — Tidak perlu login
// ============================================================
Route::get('/', [MapController::class, 'index'])->name('map');
Route::get('/api/map-data', [MapController::class, 'getMapData'])->name('api.map-data');

// ============================================================
// ADMIN AUTH — Login & Logout
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Halaman login (hanya untuk yang belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ============================================================
    // ADMIN PANEL — Harus sudah login
    // ============================================================
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('parking', ParkingSpotController::class);
    });
});
