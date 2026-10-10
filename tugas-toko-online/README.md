# Tugas Toko Online (Laravel 13 + MySQL)


```bash
composer install
```

`.env`:

```
DB_CONNECTION=mysql
DB_DATABASE=db_toko
DB_USERNAME=root
DB_PASSWORD=
```

Buat database kosong `db_toko`, lalu:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Akun de,p: `budi` / `rahasia123`, `siti` / `rahasia456`.

## Fitur

- Daftar barang (12 barang, ada gambar, nama, harga, stok) dapat dilihat tanpa login. Barang berstok 0 tidak dapat dibeli.
- Login / daftar / logout. Keranjang, checkout, dan riwayat pesanan wajib login.
- Keranjang (session): ubah jumlah, hapus, subtotal dan total. Jumlah tidak boleh melebihi stok.
- Checkout dalam satu transaksi database: kunci baris barang, cek stok, buat `orders`, isi `order_details`
  (dengan `harga_satuan` arsip), kurangi stok, lalu kosongkan keranjang. Harga selalu dari database.
- Riwayat pesanan dan detail, hanya milik pengguna yang login.

## Tabel

`users`, `products`, `orders`, `order_details` 