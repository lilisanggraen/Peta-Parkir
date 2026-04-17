<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\ParkingSpotController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

// 1. Memaksa HTTPS di Railway
if (app()->environment('production')) {
    URL::forceScheme('https');
}

// ============================================================
// HALAMAN PUBLIK
// ============================================================
Route::get('/', [MapController::class, 'index'])->name('map');
Route::get('/api/map-data', [MapController::class, 'getMapData'])->name('api.map-data');

// ============================================================
// AUTHENTICATION (Dibuat Manual & Terpisah)
// Kita buat rute ini punya 2 nama agar cocok dengan Blade manapun
// ============================================================
Route::middleware('guest')->group(function () {
    // Rute Tampilan Login
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');

    // Rute Proses Login (Kunci Perbaikan di Sini)
    Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
});

// Alias tambahan untuk keamanan (agar admin.login.post juga terbaca)
Route::name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/admin/login-alias', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/admin/login-alias', [AuthController::class, 'login'])->name('login.post');
    });
});

// Alias redirect sederhana
Route::get('/login', function () {
    return redirect()->route('login');
});

// ============================================================
// ADMIN PANEL (Harus Login)
// ============================================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('parking', ParkingSpotController::class);
});

// ============================================================
// DEBUG TOOL
// ============================================================
Route::get('/debug-user', function () {
    $user = \App\Models\User::updateOrCreate(
        ['email' => 'admin@parkir.com'],
        [
            'name' => 'Admin Salatiga',
            'password' => \Illuminate\Support\Facades\Hash::make('rahasia123'),
        ]
    );
    return "User siap digunakan: " . $user->email;
});
