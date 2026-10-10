<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = null;   // kunci komposit (id_order, id_barang)
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_order', 'id_barang', 'harga_satuan', 'jumlah_beli'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_barang', 'id_barang');
    }
}
