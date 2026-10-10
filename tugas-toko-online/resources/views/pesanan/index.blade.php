@extends('layout')

@section('judul', 'Riwayat Pesanan')

@section('isi')
    <h2>Riwayat Pesanan</h2>

    @if ($orders->isEmpty())
        <p class="kosong">Anda belum memiliki pesanan.</p>
        <a class="btn" href="{{ route('home') }}">&laquo; Mulai belanja</a>
    @else
        <table>
            <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th class="angka">Jenis barang</th>
                <th class="angka">Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $o)
                <tr>
                    <td>{{ $o->id_order }}</td>
                    <td>{{ $o->tanggal_order->format('d-m-Y H:i') }}</td>
                    <td class="angka">{{ $o->details_count }}</td>
                    <td class="angka">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                    <td><a class="btn" href="{{ route('pesanan.show', $o->id_order) }}">Detail</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
