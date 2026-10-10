# Tugas 2 – Keranjang Belanja Tanpa Login 

```bash
composer install
```

`.env`:

```
DB_CONNECTION=mysql
DB_DATABASE=db_tugas2
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file   

Buat database kosong `db_tugas2`, lalu:

```bash
php artisan migrate --seed
php artisan serve
```

Buka http://localhost:8000/index

## Rancangan

- Tabel `barang` (id, nama, harga, stok) di MySQL, 5 produk dari seeder.
- Keranjang disimpan di session dengan bentuk `[id_barang => jumlah]`. Nama dan harga selalu dibaca dari tabel `barang`.
- Fitur: tambah (produk sama menambah jumlah), tombol + dan -, hapus satu item, kosongkan keranjang.
  Jumlah menjadi 0 menghapus item otomatis; jumlah tidak boleh melebihi stok.
