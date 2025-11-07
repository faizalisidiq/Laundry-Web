<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
// ROUTE UNTUK Dashboard
// ===========================
// Route::get('/dashboard', function () {
//     return auth()->user();
//     return view('admin.dashboard');
// })->name('dashboard');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');



// ===========================
// ROUTE UNTUK ADMINSIDE
// ===========================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
