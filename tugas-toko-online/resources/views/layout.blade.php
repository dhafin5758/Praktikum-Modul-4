<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Toko Alat Tulis')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; margin: 0; color: #222; background: #f6f7f9; }
        header { background: #1a57a0; color: #fff; padding: .75rem 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .5rem; }
        header a { color: #fff; text-decoration: none; margin-left: 1rem; }
        header .brand { font-size: 1.25rem; font-weight: bold; margin-left: 0; }
        nav { display: flex; align-items: center; flex-wrap: wrap; }
        nav form { display: inline; margin-left: 1rem; }
        nav button { background: #fff; color: #1a57a0; border: 0; padding: .35rem .8rem; border-radius: 4px; cursor: pointer; }
        .badge { background: #fff; color: #1a57a0; border-radius: 10px; padding: 0 .5rem; font-size: .85rem; margin-left: .25rem; }
        main { max-width: 980px; margin: 1.5rem auto; padding: 0 1rem; }
        .pesan { background: #e7f6ec; border-left: 4px solid #1a7f37; padding: .6rem .9rem; margin-bottom: 1rem; }
        .galat { background: #fdecea; border-left: 4px solid #b42318; padding: .6rem .9rem; margin-bottom: 1rem; color: #7a1a12; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 1rem; }
        .card { background: #fff; border-radius: 8px; padding: .9rem; box-shadow: 0 1px 3px rgba(0,0,0,.12); display: flex; flex-direction: column; }
        .card img { width: 100%; height: 130px; object-fit: contain; background: #f0f2f5; border-radius: 6px; }
        .card h3 { margin: .6rem 0 .2rem; font-size: 1rem; }
        .harga { font-weight: bold; color: #1a57a0; }
        .stok { font-size: .85rem; color: #555; margin: .2rem 0 .6rem; }
        .stok.habis { color: #b42318; font-weight: bold; }
        .card form { margin-top: auto; }
        button, .btn { cursor: pointer; padding: .45rem .9rem; border: 1px solid #1a57a0; background: #fff; color: #1a57a0; border-radius: 4px; font-size: .9rem; text-decoration: none; display: inline-block; }
        button.utama, .btn.utama { background: #1a57a0; color: #fff; }
        button.bahaya { border-color: #b42318; color: #b42318; }
        button:disabled { opacity: .5; cursor: not-allowed; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
        th, td { padding: .6rem .75rem; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #eef2f7; }
        td.angka, th.angka { text-align: right; }
        .thumb { width: 44px; height: 44px; object-fit: contain; background: #f0f2f5; border-radius: 4px; vertical-align: middle; margin-right: .6rem; }
        .total { text-align: right; font-size: 1.2rem; font-weight: bold; margin: 1rem 0; }
        .form-box { background: #fff; padding: 1.5rem; border-radius: 8px; max-width: 440px; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,.12); }
        .form-box label { display: block; margin-top: .9rem; font-size: .9rem; }
        .form-box input, .form-box textarea { width: 100%; padding: .5rem; margin-top: .25rem; border: 1px solid #c7ccd4; border-radius: 4px; font: inherit; }
        .form-box button { margin-top: 1.2rem; width: 100%; }
        .inline { display: inline; }
        .qty { width: 70px; padding: .3rem; }
        .kecil { color: #666; font-size: .85rem; }
        .kosong { color: #777; }
    </style>
</head>
<body>
@php($jumlahItem = auth()->check() ? collect(session('cart', []))->sum() : 0)
<header>
    <a class="brand" href="{{ route('home') }}">Toko Alat Tulis</a>
    <nav>
        <a href="{{ route('home') }}">Barang</a>
        @auth
            <a href="{{ route('keranjang') }}">Keranjang <span class="badge">{{ $jumlahItem }}</span></a>
            <a href="{{ route('pesanan.index') }}">Pesanan Saya</a>
            <span style="margin-left:1rem">Halo, {{ auth()->user()->nama_lengkap }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('daftar') }}">Daftar</a>
        @endauth
    </nav>
</header>
<main>
    @if (session('pesan'))
        <div class="pesan">{{ session('pesan') }}</div>
    @endif
    @if (session('galat'))
        <div class="galat">{{ session('galat') }}</div>
    @endif
    @if ($errors->any() && !$errors->has('login'))
        <div class="galat">
            @foreach ($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    @yield('isi')
</main>
</body>
</html>
