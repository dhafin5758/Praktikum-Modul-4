<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Toko Alat Tulis')</title>
    <style>
        body { font-family: sans-serif; margin: 0; color: #222; }
        header { display: flex; justify-content: space-between; align-items: center; background: #1a57a0; padding: .75rem 1.5rem; }
        header a { color: #fff; text-decoration: none; }
        header .brand { font-size: 1.2rem; font-weight: bold; }
        header .cart { background: #fff; color: #1a57a0; padding: .3rem .8rem; border-radius: 4px; font-weight: bold; }
        main { max-width: 760px; margin: 1.5rem auto; padding: 0 1rem; }
        .pesan { background: #e8f3ff; border-left: 4px solid #1a57a0; padding: .5rem .75rem; margin-bottom: 1rem; }
        .row { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; padding: .75rem 0; gap: 1rem; }
        .img { width: 48px; height: 48px; background: #e5e7eb; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; color: #888; font-size: .7rem; margin-right: .75rem; }
        .info { display: flex; align-items: center; flex: 1; }
        button { cursor: pointer; padding: .35rem .7rem; border: 1px solid #1a57a0; background: #fff; color: #1a57a0; border-radius: 4px; }
        button.utama { background: #1a57a0; color: #fff; }
        button.bahaya { border-color: #b42318; color: #b42318; }
        .qty { display: inline-flex; align-items: center; gap: .4rem; }
        form { display: inline; margin: 0; }
        .total { font-size: 1.2rem; font-weight: bold; margin: 1rem 0; }
        .kosong { color: #777; }
    </style>
</head>
<body>
@php($jumlahItem = collect(session('keranjang', []))->sum())
<header>
    <a class="brand" href="{{ route('index') }}">Toko Alat Tulis</a>
    <a class="cart" href="{{ route('keranjang') }}">Keranjang ({{ $jumlahItem }})</a>
</header>
<main>
    @if (session('pesan'))
        <div class="pesan">{{ session('pesan') }}</div>
    @endif
    @yield('isi')
</main>
</body>
</html>
