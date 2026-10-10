<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Publik: daftar barang boleh dilihat tanpa login
Route::get('/', [ProductController::class, 'index'])->name('home');

// Hanya tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'register']);
});

// Wajib login: keranjang, checkout, riwayat pesanan
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah/{id}', [CartController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/ubah/{id}', [CartController::class, 'ubah'])->name('keranjang.ubah');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/kosongkan', [CartController::class, 'kosongkan'])->name('keranjang.kosongkan');

    Route::get('/checkout', [OrderController::class, 'formCheckout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'prosesCheckout'])->name('checkout.proses');

    Route::get('/pesanan', [OrderController::class, 'riwayat'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [OrderController::class, 'detail'])->name('pesanan.show');
});
