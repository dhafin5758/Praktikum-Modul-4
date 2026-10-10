@extends('layout')

@section('judul', 'Keranjang Belanja')

@section('isi')
    <h2>Keranjang belanja <small style="font-weight:normal;color:#777">Tanpa login</small></h2>

    @if (count($items) === 0)
        <p class="kosong">Keranjang kosong.</p>
        <p><a href="{{ route('index') }}">&laquo; Kembali ke daftar barang</a></p>
    @else
        @foreach ($items as $item)
            @php($b = $item['barang'])
            <div class="row">
                <div>
                    <strong>{{ $b->nama }}</strong><br>
                    Rp {{ number_format($b->harga, 0, ',', '.') }} x {{ $item['jumlah'] }}
                    = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                </div>
                <div class="qty">
                    <form method="POST" action="{{ route('keranjang.ubah', $b->id) }}">
                        @csrf
                        <input type="hidden" name="aksi" value="kurang">
                        <button type="submit">-</button>
                    </form>
                    <span>{{ $item['jumlah'] }}</span>
                    <form method="POST" action="{{ route('keranjang.ubah', $b->id) }}">
                        @csrf
                        <input type="hidden" name="aksi" value="tambah">
                        <button type="submit" @disabled($item['jumlah'] >= $b->stok)>+</button>
                    </form>
                    <form method="POST" action="{{ route('keranjang.hapus', $b->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bahaya">hps</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="total">Total Rp {{ number_format($total, 0, ',', '.') }}</div>

        <form method="POST" action="{{ route('keranjang.kosongkan') }}">
            @csrf
            <button type="submit" class="bahaya">Kosongkan keranjang</button>
        </form>
        <p><a href="{{ route('index') }}">&laquo; Lanjut belanja</a></p>
    @endif
@endsection
