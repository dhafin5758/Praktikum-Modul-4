@extends('layout')

@section('judul', 'Daftar Barang')

@section('isi')
    <h2>Daftar Barang</h2>
    @guest
        <p class="kecil">Anda boleh melihat barang tanpa login. Untuk membeli, silakan
            <a href="{{ route('login') }}">login</a> atau <a href="{{ route('daftar') }}">daftar</a>.</p>
    @endguest

    <div class="grid">
        @foreach ($products as $p)
            <div class="card">
                <img src="{{ $p->urlGambar() }}" alt="{{ $p->nama_barang }}">
                <h3>{{ $p->nama_barang }}</h3>
                <div class="harga">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                <div class="stok {{ $p->stok < 1 ? 'habis' : '' }}">
                    {{ $p->stok < 1 ? 'Stok habis' : 'Stok: ' . $p->stok }}
                </div>
                <div class="kecil" style="margin-bottom:.6rem">{{ $p->deskripsi }}</div>

                @auth
                    <form method="POST" action="{{ route('keranjang.tambah', $p->id_barang) }}">
                        @csrf
                        <button type="submit" class="utama" @disabled($p->stok < 1)>
                            {{ $p->stok < 1 ? 'Tidak dapat dibeli' : 'Masukkan ke keranjang' }}
                        </button>
                    </form>
                @else
                    <a class="btn" href="{{ route('login') }}">Login untuk membeli</a>
                @endauth
            </div>
        @endforeach
    </div>
@endsection
