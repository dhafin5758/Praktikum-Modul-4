@extends('layout')

@section('judul', 'Login')

@section('isi')
    <div class="form-box">
        <h2 style="margin-top:0">Login</h2>

        @error('login')
            <div class="galat">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="utama">Masuk</button>
        </form>
        <p class="kecil">Belum punya akun? <a href="{{ route('daftar') }}">Daftar</a></p>
    </div>
@endsection
