<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            // Password otomatis di-hash saat disimpan lewat model
            'password' => 'hashed',
        ];
    }
}
