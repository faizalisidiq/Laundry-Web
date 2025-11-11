<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// ===========================
// ROUTE UNTUK USERSIDE
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
// ROUTE UNTUK ADMINSIDE
// ===========================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===========================
// ROUTE UNTUK Dashboard & CRUD
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Layanan
    Route::resource('layanan', LayananController::class);
    
    // Pesanan
    Route::resource('pesanan', OrderController::class);
    Route::post('pesanan/{pesanan}/update-status', [OrderController::class, 'updateStatus'])->name('pesanan.update-status');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Role Management
    Route::resource('roles', RoleController::class);
});