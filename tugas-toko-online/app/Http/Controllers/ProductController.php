<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /** Daftar barang boleh dilihat tanpa login. */
    public function index(): View
    {
        return view('produk', [
            'products' => Product::orderBy('id_barang')->get(),
        ]);
    }
}
