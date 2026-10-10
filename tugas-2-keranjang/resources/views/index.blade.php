@extends('layout')

@section('judul', 'Daftar Barang')

@section('isi')
    <h2>Daftar barang</h2>

    @foreach ($barang as $b)
        <div class="row">
            <div class="info">
                <span class="img">img</span>
                <div>
                    <strong>{{ $b->nama }}</strong><br>
                    Rp {{ number_format($b->harga, 0, ',', '.') }}
                    <small>(stok: {{ $b->stok }})</small>
                </div>
            </div>
            <form method="POST" action="{{ route('keranjang.tambah', $b->id) }}">
                @csrf
                <button type="submit" class="utama" @disabled($b->stok < 1)>
                    {{ $b->stok < 1 ? 'Stok habis' : 'Masukkan ke keranjang' }}
                </button>
            </form>
        </div>
    @endforeach
@endsection
