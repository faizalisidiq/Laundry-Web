<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// ===========================
// ROUTE UNTUK USERSIDE (Frontend)
// ===========================
Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('user.tracking');
    })->name('user.tracking');

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
        Route::post('/pesanan/{pesanan}/update-status', [OrderController::class, 'updateStatus'])
            ->name('pesanan.update-status');
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

// ===========================
// REDIRECT ROOT
// ===========================
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});
