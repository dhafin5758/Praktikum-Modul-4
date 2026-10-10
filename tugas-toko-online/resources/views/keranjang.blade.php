@extends('layout')

@section('judul', 'Keranjang Belanja')

@section('isi')
    <h2>Keranjang Belanja</h2>

    @if (count($items) === 0)
        <p class="kosong">Keranjang masih kosong.</p>
        <a class="btn" href="{{ route('home') }}">&laquo; Lihat daftar barang</a>
    @else
        <table>
            <thead>
            <tr>
                <th>Barang</th>
                <th class="angka">Harga</th>
                <th>Jumlah</th>
                <th class="angka">Subtotal</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                @php($p = $item['product'])
                <tr>
                    <td><img class="thumb" src="{{ $p->urlGambar() }}" alt="">{{ $p->nama_barang }}</td>
                    <td class="angka">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td>
                        <form class="inline" method="POST" action="{{ route('keranjang.ubah', $p->id_barang) }}">
                            @csrf
                            <input class="qty" type="number" name="jumlah" min="1" max="{{ $p->stok }}" value="{{ $item['jumlah'] }}">
                            <button type="submit">Ubah</button>
                        </form>
                        <div class="kecil">stok: {{ $p->stok }}</div>
                    </td>
                    <td class="angka">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    <td>
                        <form class="inline" method="POST" action="{{ route('keranjang.hapus', $p->id_barang) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bahaya">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="total">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>

        <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap">
            <form method="POST" action="{{ route('keranjang.kosongkan') }}">
                @csrf
                <button type="submit" class="bahaya">Kosongkan keranjang</button>
            </form>
            <div>
                <a class="btn" href="{{ route('home') }}">Lanjut belanja</a>
                <a class="btn utama" href="{{ route('checkout') }}">Checkout</a>
            </div>
        </div>
    @endif
@endsection
