<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/index');

Route::get('/index', [CartController::class, 'index'])->name('index');
Route::get('/keranjang', [CartController::class, 'keranjang'])->name('keranjang');

Route::post('/keranjang/tambah/{id}', [CartController::class, 'tambah'])->whereNumber('id')->name('keranjang.tambah');
Route::post('/keranjang/ubah/{id}', [CartController::class, 'ubah'])->whereNumber('id')->name('keranjang.ubah');
Route::delete('/keranjang/hapus/{id}', [CartController::class, 'hapus'])->whereNumber('id')->name('keranjang.hapus');
Route::post('/keranjang/kosongkan', [CartController::class, 'kosongkan'])->name('keranjang.kosongkan');
