<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\Admin\ParkingSpotController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// ============================================================
// HALAMAN PUBLIK
// ============================================================
Route::get('/', [MapController::class, 'index'])->name('map');
Route::get('/api/map-data', [MapController::class, 'getMapData'])->name('api.map-data');

// ============================================================
// AUTHENTICATION (Guest Middleware)
// ============================================================
Route::middleware('guest')->group(function () {
    // Gunakan satu jalur utama untuk login agar tidak bingung
    Route::get('/admin/login-alias', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login-alias', [AuthController::class, 'login'])->name('login.post');
});

// Redirect jika ada yang akses /login atau /admin/login biasa
Route::redirect('/login', '/admin/login-alias');
Route::redirect('/admin/login', '/admin/login-alias');

// ============================================================
// ADMIN PANEL (Harus Login)
// ============================================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Admin
    Route::get('/dashboard', [MapController::class, 'adminDashboard'])->name('dashboard');

    // CRUD Data Parkir
    Route::resource('parking', ParkingSpotController::class);
});

// ============================================================
// DEBUG TOOL (Hanya untuk buat user pertama kali)
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
