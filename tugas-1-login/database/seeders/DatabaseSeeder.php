<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password plain di sini akan di-hash oleh cast 'hashed' pada model User
        User::create([
            'username'     => 'budi',
            'password'     => 'rahasia123',
            'nama_lengkap' => 'Budi Santoso',
        ]);

        User::create([
            'username'     => 'siti',
            'password'     => 'rahasia456',
            'nama_lengkap' => 'Siti Aminah',
        ]);
    }
}
