<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_barang';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_barang', 'nama_barang', 'deskripsi', 'harga', 'stok', 'gambar',
    ];

    public function urlGambar(): string
    {
        return asset('images/produk/' . ($this->gambar ?: 'default.svg'));
    }
}
