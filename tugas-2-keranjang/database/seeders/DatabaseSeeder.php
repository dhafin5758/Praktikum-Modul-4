<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 50],
            ['nama' => 'Pulpen',     'harga' => 3000, 'stok' => 100],
            ['nama' => 'Penggaris',  'harga' => 4000, 'stok' => 30],
            ['nama' => 'Pensil 2B',  'harga' => 2500, 'stok' => 80],
            ['nama' => 'Penghapus',  'harga' => 1500, 'stok' => 60],
        ];

        foreach ($data as $row) {
            Barang::create($row);
        }
    }
}
