<?php

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
// Route::prefix('admin')->group(function () {
//     Route::get('/', function () {
//         return "Halaman Dashboard Admin (Coming Soon)";
//     })->name('admin.dashboard');
// });
