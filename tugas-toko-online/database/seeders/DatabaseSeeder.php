<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun uji (password di-hash oleh cast 'hashed' pada model User)
        User::create([
            'id_user'      => 'USR000001',
            'nama_lengkap' => 'Budi Santoso',
            'email'        => 'budi@example.com',
            'username'     => 'budi',
            'password'     => 'rahasia123',
            'no_hp'        => '081234567890',
            'alamat'       => 'Jl. Merdeka No. 10, Bandung',
        ]);

        User::create([
            'id_user'      => 'USR000002',
            'nama_lengkap' => 'Siti Aminah',
            'email'        => 'siti@example.com',
            'username'     => 'siti',
            'password'     => 'rahasia456',
            'no_hp'        => '081298765432',
            'alamat'       => 'Jl. Dago No. 5, Bandung',
        ]);

        // 12 barang; satu barang (BRG012) berstok 0 untuk menguji aturan stok habis
        $barang = [
            ['BRG001', 'Buku Tulis',          'Buku tulis 38 lembar bergaris.',               5000, 50, 'buku-tulis.svg'],
            ['BRG002', 'Pulpen',              'Pulpen tinta hitam 0,5 mm.',                   3000, 100, 'pulpen.svg'],
            ['BRG003', 'Penggaris',           'Penggaris plastik 30 cm.',                     4000, 30, 'penggaris.svg'],
            ['BRG004', 'Pensil 2B',           'Pensil kayu 2B untuk ujian dan menggambar.',   2500, 80, 'pensil-2b.svg'],
            ['BRG005', 'Penghapus',           'Penghapus karet putih bersih.',                1500, 60, 'penghapus.svg'],
            ['BRG006', 'Spidol Papan Tulis',  'Spidol whiteboard warna hitam.',               9000, 40, 'spidol.svg'],
            ['BRG007', 'Stabilo',             'Penanda teks warna kuning.',                   7000, 35, 'stabilo.svg'],
            ['BRG008', 'Correction Tape',     'Pita koreksi 5 mm x 8 m.',                     8500, 25, 'correction-tape.svg'],
            ['BRG009', 'Map Plastik',         'Map plastik dengan kancing, ukuran folio.',    3500, 70, 'map-plastik.svg'],
            ['BRG010', 'Stapler Mini',        'Stapler mini beserta isi 1 box.',             15000, 20, 'stapler.svg'],
            ['BRG011', 'Lem Stik',            'Lem stik 8 gram, tidak lengket di tangan.',    6000, 45, 'lem-stik.svg'],
            ['BRG012', 'Kalkulator Ilmiah',   'Kalkulator ilmiah 240 fungsi. (stok habis)',  95000, 0, 'kalkulator.svg'],
        ];

        foreach ($barang as [$id, $nama, $deskripsi, $harga, $stok, $gambar]) {
            Product::create([
                'id_barang'   => $id,
                'nama_barang' => $nama,
                'deskripsi'   => $deskripsi,
                'harga'       => $harga,
                'stok'        => $stok,
                'gambar'      => $gambar,
            ]);
        }
    }
}
