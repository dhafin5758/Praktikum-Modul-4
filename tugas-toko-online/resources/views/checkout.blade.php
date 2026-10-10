@extends('layout')

@section('judul', 'Checkout')

@section('isi')
    <h2>Checkout</h2>

    <table>
        <thead>
        <tr>
            <th>Barang</th>
            <th class="angka">Harga</th>
            <th class="angka">Jumlah</th>
            <th class="angka">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item['product']->nama_barang }}</td>
                <td class="angka">Rp {{ number_format($item['product']->harga, 0, ',', '.') }}</td>
                <td class="angka">{{ $item['jumlah'] }}</td>
                <td class="angka">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total">Total bayar: Rp {{ number_format($total, 0, ',', '.') }}</div>
    <p class="kecil" style="text-align:right">Ongkos kirim diabaikan.</p>

    <div class="form-box" style="max-width:none">
        <form method="POST" action="{{ route('checkout.proses') }}">
            @csrf
            <label for="alamat_pengiriman">Alamat pengiriman</label>
            <textarea id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ old('alamat_pengiriman', $alamat) }}</textarea>
            <button type="submit" class="utama">Buat pesanan</button>
        </form>
    </div>
@endsection
