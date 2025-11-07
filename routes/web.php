<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ===========================
// ROUTE UNTUK USERSIDE
// ===========================
Route::prefix('/')->group(function () {
    // Halaman Tracking
    Route::get('/', function () {
        return view('user.tracking');
    })->name('user.tracking');

    // Halaman Lokasi
    Route::get('/lokasi', function () {
        return view('user.lokasi');
    })->name('user.lokasi');
});




// ===========================
// ROUTE UNTUK ADMINSIDE
// ===========================
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
