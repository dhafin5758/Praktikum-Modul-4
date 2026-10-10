<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Keranjang pengguna yang sudah login, disimpan di session: [id_barang => jumlah].
 * Harga dan nama selalu dibaca dari tabel products.
 */
class CartController extends Controller
{
    public const KEY = 'cart';

    public static function baca(Request $request): array
    {
        $cart = $request->session()->get(self::KEY, []);
        if (!is_array($cart)) {
            return [];
        }

        $bersih = [];
        foreach ($cart as $id => $jumlah) {
            $jumlah = (int) $jumlah;
            if ($jumlah > 0) {
                $bersih[(string) $id] = $jumlah;
            }
        }

        return $bersih;
    }

    /**
     * Susun item keranjang dari database.
     * Mengembalikan [items, total]. Jumlah dibatasi stok; barang hilang / stok 0 dilewati.
     */
    public static function susunItem(array $cart): array
    {
        $products = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');

        $items = [];
        $total = 0;
        foreach ($cart as $id => $jumlah) {
            $p = $products->get($id);
            if (!$p || $p->stok < 1) {
                continue;
            }
            $jumlah = min($jumlah, $p->stok);
            $subtotal = (float) $p->harga * $jumlah;
            $total += $subtotal;
            $items[] = ['product' => $p, 'jumlah' => $jumlah, 'subtotal' => $subtotal];
        }

        return [$items, $total];
    }

    public function index(Request $request): View
    {
        [$items, $total] = self::susunItem(self::baca($request));

        return view('keranjang', ['items' => $items, 'total' => $total]);
    }

    public function tambah(Request $request, string $id): RedirectResponse
    {
        $p = Product::findOrFail($id);

        if ($p->stok < 1) {
            return back()->with('galat', $p->nama_barang . ' stok habis dan tidak dapat dibeli.');
        }

        $cart = self::baca($request);
        $sekarang = $cart[$id] ?? 0;

        if ($sekarang + 1 > $p->stok) {
            return back()->with('galat', 'Jumlah ' . $p->nama_barang . ' di keranjang sudah mencapai stok (' . $p->stok . ').');
        }

        $cart[$id] = $sekarang + 1;
        $request->session()->put(self::KEY, $cart);

        return back()->with('pesan', $p->nama_barang . ' dimasukkan ke keranjang.');
    }

    public function ubah(Request $request, string $id): RedirectResponse
    {
        $data = $request->validate(['jumlah' => ['required', 'integer', 'min:1']]);

        $cart = self::baca($request);
        if (!isset($cart[$id])) {
            return redirect()->route('keranjang');
        }

        $p = Product::find($id);
        if (!$p || $p->stok < 1) {
            unset($cart[$id]);
            $request->session()->put(self::KEY, $cart);
            return redirect()->route('keranjang')->with('galat', 'Barang sudah tidak tersedia dan dihapus dari keranjang.');
        }

        if ($data['jumlah'] > $p->stok) {
            return redirect()->route('keranjang')
                ->with('galat', 'Jumlah ' . $p->nama_barang . ' melebihi stok (maksimal ' . $p->stok . ').');
        }

        $cart[$id] = (int) $data['jumlah'];
        $request->session()->put(self::KEY, $cart);

        return redirect()->route('keranjang')->with('pesan', 'Jumlah diperbarui.');
    }

    public function hapus(Request $request, string $id): RedirectResponse
    {
        $cart = self::baca($request);
        unset($cart[$id]);
        $request->session()->put(self::KEY, $cart);

        return redirect()->route('keranjang')->with('pesan', 'Barang dihapus dari keranjang.');
    }

    public function kosongkan(Request $request): RedirectResponse
    {
        $request->session()->forget(self::KEY);

        return redirect()->route('keranjang')->with('pesan', 'Keranjang dikosongkan.');
    }
}
