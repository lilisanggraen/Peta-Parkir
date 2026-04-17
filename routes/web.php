<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\ParkingSpotController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

// Memaksa HTTPS di lingkungan production (Railway) agar tidak error 419
if (app()->environment('production')) {
    URL::forceScheme('https');
}

// ============================================================
// REDIRECT / LOGIN ALIAS
// Penting: Agar middleware 'auth' tidak error 'Route [login] not defined'
// ============================================================
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

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

// ============================================================
// DEBUG ROUTE (Hapus jika sudah berhasil login sekali)
// ============================================================
Route::get('/debug-user', function () {
    $user = \App\Models\User::updateOrCreate(
        ['email' => 'admin@parkir.com'],
        [
            'name' => 'Admin Baru',
            'password' => \Illuminate\Support\Facades\Hash::make('rahasia123'),
        ]
    );
    return "User berhasil dibuat/diperbarui: " . $user->email;
});
