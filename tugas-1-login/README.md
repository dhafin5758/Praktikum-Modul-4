
## Cara install

```bash
composer install
```

Buat database kosong `db_tugas`, lalu ubah `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tugas
DB_USERNAME=root
DB_PASSWORD=
```



```bash
php artisan migrate:fresh --seed
php artisan serve
```

Buka http://localhost:8000/login

Akun demo: `budi` / `rahasia123`, `siti` / `rahasia456`
