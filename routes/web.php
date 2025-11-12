<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController; 

// ===========================
// ROUTE UNTUK USERSIDE (Frontend)
// ===========================
Route::prefix('/')->group(function () {
    // Halaman tracking input resi
    Route::get('/', [TrackingController::class, 'index'])->name('user.tracking');
    Route::get('/tracking/{resi}', [TrackingController::class, 'show'])->name('tracking.show');
    
    // Lokasi (static page)
    Route::get('/lokasi', function () {
        return view('user.lokasi');
    })->name('user.lokasi');
});

// ===========================
// ROUTE UNTUK AUTHENTIKASI
// ===========================

// Guest only (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

// Authenticated only (sudah login)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pesanan - Admin dan Superadmin
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::resource('pesanan', OrderController::class);
        
        // Additional routes untuk pesanan
        Route::put('/pesanan/{pesanan}/updateStatus', [OrderController::class, 'updateStatus'])
            ->name('pesanan.updateStatus');
        Route::get('/pesanan/{pesanan}/print', [OrderController::class, 'printStruk'])
            ->name('pesanan.print');
        Route::get('/pesanan/{pesanan}/send-whatsapp', [OrderController::class, 'sendWhatsApp'])
            ->name('pesanan.sendWhatsApp');
    });

    // Layanan - Superadmin only
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('layanan', LayananController::class);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


