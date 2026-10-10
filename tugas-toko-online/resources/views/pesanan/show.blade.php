@extends('layout')

@section('judul', 'Detail Pesanan')

@section('isi')
    <h2>Detail Pesanan {{ $order->id_order }}</h2>
    <p>
        Tanggal: {{ $order->tanggal_order->format('d-m-Y H:i') }}<br>
        Alamat pengiriman: {{ $order->alamat_pengiriman }}
    </p>

    <table>
        <thead>
        <tr>
            <th>Barang</th>
            <th class="angka">Harga satuan</th>
            <th class="angka">Jumlah</th>
            <th class="angka">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->details as $d)
            <tr>
                <td>{{ $d->product?->nama_barang ?? $d->id_barang }}</td>
                <td class="angka">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td class="angka">{{ $d->jumlah_beli }}</td>
                <td class="angka">Rp {{ number_format($d->harga_satuan * $d->jumlah_beli, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total">Total bayar: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
    <a class="btn" href="{{ route('pesanan.index') }}">&laquo; Kembali ke riwayat</a>
@endsection
