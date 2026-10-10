<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Hanya untuk tamu: yang sudah login diarahkan ke dashboard
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Hanya untuk yang sudah login: tamu dialihkan ke route bernama "login"
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
