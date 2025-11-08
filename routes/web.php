<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OrderController;
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
    Route::resource('layanan', LayananController::class);
    Route::resource('pesanan', OrderController::class);
    Route::post('pesanan/{pesanan}/update-status', [OrderController::class, 'updateStatus'])->name('pesanan.update-status');
});