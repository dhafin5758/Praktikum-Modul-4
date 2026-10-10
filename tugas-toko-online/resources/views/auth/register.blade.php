@extends('layout')

@section('judul', 'Daftar')

@section('isi')
    <div class="form-box">
        <h2 style="margin-top:0">Daftar Akun</h2>

        <form method="POST" action="{{ route('daftar') }}">
            @csrf
            <label for="nama_lengkap">Nama lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>

            <label for="password">Password (minimal 6 karakter)</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Ulangi password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <label for="no_hp">No. HP</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}">

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>

            <button type="submit" class="utama">Daftar</button>
        </form>
        <p class="kecil">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </div>
@endsection
