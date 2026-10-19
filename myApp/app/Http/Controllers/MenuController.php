<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('nama_produk')
            ->get();

        return view('menu', compact('products'));
    }


    public function addToCart(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        $id = $product->id_produk;

        if (isset($cart[$id])) {
            $cart[$id]['jumlah']++;
        } else {
            $cart[$id] = [
                'id_produk' => $product->id_produk,
                'nama_produk' => $product->nama_produk,
                'harga' => $product->harga,
                'jumlah' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('menu');
    }


    public function cart()
    {
        $cart = session()->get('cart', []);

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('cart', compact('cart', 'total'));
    }


    public function updateCart(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        $id = $product->id_produk;

        if (!isset($cart[$id])) {
            return redirect()->route('menu');
        }

        $jumlah = (int) $request->jumlah;

        if ($jumlah <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['jumlah'] = $jumlah;
        }

        session()->put('cart', $cart);

        return redirect()->route('menu');
    }


    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('checkout', compact('cart', 'total'));
    }


    public function processCheckout(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $order = DB::transaction(function () use ($request, $cart, $total) {

            $order = Order::create([
                'nomor_pesanan' => 'MB-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'email_pembeli' => $request->email,
                'total' => $total,
                'metode_bayar' => 'Belum Dipilih',
                'status' => 'Menunggu Pembayaran',
                'tanggal' => now(),
            ]);

            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('payment', $order);
    }


    public function payment(Order $order)
    {
        /*
         * Jika metode pembayaran QRIS,
         * tampilkan halaman pembayaran QRIS.
         */
        if ($order->metode_bayar === 'QRIS') {
            return view('payment-qris', compact('order'));
        }

        /*
         * Jika metode pembayaran Tunai,
         * tampilkan halaman pembayaran tunai.
         */
        if ($order->metode_bayar === 'Tunai') {
            return view('payment-tunai', compact('order'));
        }

        /*
         * Jika metode pembayaran belum dipilih,
         * tampilkan halaman pilihan pembayaran.
         */
        return view('payment', compact('order'));
    }


    public function processPayment(Request $request, Order $order)
    {
        $request->validate([
            'metode_bayar' => ['required', 'in:QRIS,Tunai'],
        ]);

        $order->update([
            'metode_bayar' => $request->metode_bayar,
        ]);

        /*
         * Setelah metode pembayaran dipilih,
         * redirect ke halaman GET.
         */
        return redirect()->route('payment', $order);
    }


    public function paymentSubmitted(Order $order)
    {
        /*
         * Pembeli sudah menyelesaikan pembayaran
         * dan menunggu konfirmasi kasir.
         */
        $order->update([
            'status' => 'Menunggu Konfirmasi',
        ]);

        /*
         * Redirect ke halaman GET agar aman
         * ketika halaman di-refresh.
         */
        return redirect()->route('payment.waiting', $order);
    }


    public function paymentWaiting(Order $order)
    {
        return view('payment-waiting', compact('order'));
    }
}