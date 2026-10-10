<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Keranjang belanja tanpa login, disimpan di SESSION Laravel.
 *
 * Yang disimpan di session hanya: [id_barang => jumlah].
 * Nama dan harga SELALU diambil dari tabel barang (database).
 */
class CartController extends Controller
{
    private const KEY = 'keranjang';

    /** Baca keranjang dari session dan pastikan bentuknya valid. */
    private function baca(Request $request): array
    {
        $cart = $request->session()->get(self::KEY, []);
        if (!is_array($cart)) {
            return [];
        }

        $bersih = [];
        foreach ($cart as $id => $jumlah) {
            $id = (int) $id;
            $jumlah = (int) $jumlah;
            if ($id > 0 && $jumlah > 0) {
                $bersih[$id] = $jumlah;
            }
        }

        return $bersih;
    }

    private function simpan(Request $request, array $cart): void
    {
        $request->session()->put(self::KEY, $cart);
    }

    public function index(): View
    {
        return view('index', [
            'barang' => Barang::orderBy('id')->get(),
        ]);
    }

    public function keranjang(Request $request): View
    {
        $cart = $this->baca($request);
        $barang = Barang::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;
        foreach ($cart as $id => $jumlah) {
            $b = $barang->get($id);
            if (!$b) {
                continue; // barang sudah tidak ada di database
            }
            $jumlah = min($jumlah, $b->stok);
            if ($jumlah < 1) {
                continue;
            }
            $subtotal = (float) $b->harga * $jumlah;
            $total += $subtotal;
            $items[] = [
                'barang'   => $b,
                'jumlah'   => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        return view('keranjang', ['items' => $items, 'total' => $total]);
    }

    public function tambah(Request $request, int $id): RedirectResponse
    {
        $b = Barang::findOrFail($id);
        $cart = $this->baca($request);
        $sekarang = $cart[$id] ?? 0;

        if ($sekarang + 1 > $b->stok) {
            return back()->with('pesan', 'Stok ' . $b->nama . ' tidak mencukupi.');
        }

        $cart[$id] = $sekarang + 1; // produk yang sama dipilih lagi: jumlah bertambah
        $this->simpan($request, $cart);

        return back()->with('pesan', $b->nama . ' dimasukkan ke keranjang.');
    }

    public function ubah(Request $request, int $id): RedirectResponse
    {
        $request->validate(['aksi' => ['required', 'in:tambah,kurang']]);

        $cart = $this->baca($request);
        if (!isset($cart[$id])) {
            return redirect('/keranjang');
        }

        $b = Barang::find($id);
        if (!$b) {
            unset($cart[$id]);
            $this->simpan($request, $cart);
            return redirect('/keranjang');
        }

        if ($request->input('aksi') === 'tambah') {
            if ($cart[$id] + 1 > $b->stok) {
                return redirect('/keranjang')->with('pesan', 'Stok ' . $b->nama . ' tidak mencukupi.');
            }
            $cart[$id]++;
        } else {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]); // jumlah 0 -> item dihapus otomatis
            }
        }

        $this->simpan($request, $cart);

        return redirect('/keranjang');
    }

    public function hapus(Request $request, int $id): RedirectResponse
    {
        $cart = $this->baca($request);
        unset($cart[$id]);
        $this->simpan($request, $cart);

        return redirect('/keranjang');
    }

    public function kosongkan(Request $request): RedirectResponse
    {
        $request->session()->forget(self::KEY);

        return redirect('/keranjang');
    }
}
