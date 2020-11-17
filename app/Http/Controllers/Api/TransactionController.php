<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getCheckout()
    {
        // Ambil data order + user
        $order = Order::with('user:id,name,address,phone_number')->where('user_id', Auth::id())->where('status', 0)->first();

        if (!$order) {
            return $this->SendResponse('failed', 'Order not found', null, 404);
        }

        // Ambil data keranjang
        $carts = Cart::where('order_id', $order['id'])->get();

        foreach ($carts as $cart) {
            $barang = Product::with('shop:id,shop_name,avatar')->where('id', $cart->product_id)->get();

            $product[] = $barang;
        }

        $res = [
            $order, $carts
        ];

        return response([
            'status' => 'success',
            'data' => $res,
            'product' => $product
        ]);
    }

    public function checkout()
    {
        // ubah status menjadi 1 (1 = sudah checkout)
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        if (empty($order)) {
            return $this->SendResponse('failed', 'data order not found', null, 404);
        }

        $order_id = $order->id;
        $order->status = 1;
        $order->update();

        // kurangi stok barang + tambah terjual
        $carts = Cart::where('order_id', $order_id)->get();

        foreach ($carts as $cart) {
            $product = Product::where('id', $cart->product_id)->first();

            $product->quantity -= $cart['quantity'];
            $product->sold += $cart['quantity'];
            $product->update();

            $res[] = $product;
        }

        return response([
            'status' => 'success',
            'message' => 'Ordered successfully',
            'data' => $res
        ]);
    }

    public function getDikemas()
    {
        // cek dahulu apakah ada data atau tidak
        $order = Order::where('user_id', Auth::id())->where('status', 1)->get();

        dump($order);

        if (count($order) == false) {
            return $this->SendResponse('failed', 'Data not found', null, 404);
        };

        // cek apakah penjual / pembeli
        // if ()
        // kirim respon sesuai kondisi


    }
}
