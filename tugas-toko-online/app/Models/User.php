<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user', 'nama_lengkap', 'email', 'username', 'password', 'no_hp', 'alamat',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed', // otomatis di-hash saat disimpan
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_user', 'id_user');
    }

    /** Buat id_user unik (maks 15 karakter), contoh: USR483920 */
    public static function buatId(): string
    {
        do {
            $id = 'USR' . str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::whereKey($id)->exists());

        return $id;
    }
}
