<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\ParkingSpotController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

// 1. Memaksa HTTPS di Railway agar tidak Error 419 Page Expired
if (app()->environment('production')) {
    URL::forceScheme('https');
}

// ============================================================
// HALAMAN PUBLIK
// ============================================================
Route::get('/', [MapController::class, 'index'])->name('map');
Route::get('/api/map-data', [MapController::class, 'getMapData'])->name('api.map-data');

// ============================================================
// AUTHENTICATION (Mandiri)
// ============================================================
Route::middleware('guest')->group(function () {
    // Rute GET Login: Dikenali sebagai 'login' (oleh Laravel) dan 'admin.login' (oleh Blade)
    Route::get('/admin/login', [AuthController::class, 'showLogin'])
        ->name('login')
        ->name('admin.login');

    // Rute POST Login: Dikenali sebagai 'login.post' dan 'admin.login.post' (oleh Blade kamu)
    Route::post('/admin/login', [AuthController::class, 'login'])
        ->name('login.post')
        ->name('admin.login.post');
});

// Alias redirect jika akses /login langsung
Route::get('/login', function () {
    return redirect()->route('login');
});

// ============================================================
// ADMIN PANEL (Grup dengan Prefix admin. dan Middleware Auth)
// ============================================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Resources
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('parking', ParkingSpotController::class);
});

// ============================================================
// DEBUG TOOL (Hanya untuk memastikan user admin ada)
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
