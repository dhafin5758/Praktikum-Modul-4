<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class OrderController extends Controller
{
    /** Halaman konfirmasi checkout. */
    public function formCheckout(Request $request): View|RedirectResponse
    {
        [$items, $total] = CartController::susunItem(CartController::baca($request));

        if (count($items) === 0) {
            return redirect()->route('keranjang')->with('galat', 'Keranjang kosong, tidak ada yang dapat di-checkout.');
        }

        return view('checkout', [
            'items'  => $items,
            'total'  => $total,
            'alamat' => Auth::user()->alamat,
        ]);
    }

    /**
     * Proses checkout. Semua langkah berada dalam satu transaksi database:
     * jika satu langkah gagal, seluruh perubahan dibatalkan.
     */
    public function prosesCheckout(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'min:5'],
        ]);

        $cart = CartController::baca($request);
        if (count($cart) === 0) {
            return redirect()->route('keranjang')->with('galat', 'Keranjang kosong.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $data) {
                $baris = [];
                $total = 0;

                // Kunci baris barang agar stok tidak berubah oleh checkout lain
                foreach ($cart as $id => $jumlah) {
                    $p = Product::where('id_barang', $id)->lockForUpdate()->first();

                    if (!$p) {
                        throw new RuntimeException('Barang dengan kode ' . $id . ' tidak ditemukan.');
                    }
                    if ($p->stok < $jumlah) {
                        throw new RuntimeException(
                            'Stok ' . $p->nama_barang . ' tidak mencukupi (tersisa ' . $p->stok . ').'
                        );
                    }

                    // Harga SELALU dari database, bukan dari session / browser
                    $total += (float) $p->harga * $jumlah;
                    $baris[] = ['product' => $p, 'jumlah' => $jumlah];
                }

                $order = Order::create([
                    'id_order'          => self::buatIdOrder(),
                    'id_user'           => Auth::id(),
                    'tanggal_order'     => now(),
                    'total_harga'       => $total,
                    'alamat_pengiriman' => $data['alamat_pengiriman'],
                ]);

                foreach ($baris as $b) {
                    OrderDetail::create([
                        'id_order'     => $order->id_order,
                        'id_barang'    => $b['product']->id_barang,
                        'harga_satuan' => $b['product']->harga,   // arsip harga saat dibeli
                        'jumlah_beli'  => $b['jumlah'],
                    ]);

                    $b['product']->decrement('stok', $b['jumlah']); // kurangi stok
                }

                return $order;
            });
        } catch (RuntimeException $e) {
            return redirect()->route('keranjang')->with('galat', $e->getMessage());
        }

        // Kosongkan keranjang hanya setelah transaksi berhasil
        $request->session()->forget(CartController::KEY);

        return redirect()->route('pesanan.show', $order->id_order)
            ->with('pesan', 'Checkout berhasil. Pesanan ' . $order->id_order . ' telah dibuat.');
    }

    public function riwayat(): View
    {
        $orders = Order::where('id_user', Auth::id())
            ->withCount('details')
            ->orderByDesc('tanggal_order')
            ->get();

        return view('pesanan.index', ['orders' => $orders]);
    }

    public function detail(string $id): View
    {
        // Hanya pesanan milik pengguna yang sedang login
        $order = Order::where('id_order', $id)
            ->where('id_user', Auth::id())
            ->with('details.product')
            ->firstOrFail();

        return view('pesanan.show', ['order' => $order]);
    }

    private static function buatIdOrder(): string
    {
        // Contoh: ORD2610094KQ7 (13 karakter, maksimal 15)
        do {
            $id = 'ORD' . now()->format('ymd') . strtoupper(Str::random(4));
        } while (Order::whereKey($id)->exists());

        return $id;
    }
}
