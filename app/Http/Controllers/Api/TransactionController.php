<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\KemasResource;
use App\Http\Resources\KonfirmasiResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TransactionResource;
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
        $carts = Cart::where('order_id', $order->id)->get();

        $hasil = TransactionResource::collection($carts);

        return response([
            'status' => 'success',
            'data' => [$order, $hasil],
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

    public function konfirmasi()
    {
        //pembeli
        $order = Order::with('cart')->where('user_id', Auth::id())->where('status', 1)->get();

        $res = KonfirmasiResource::collection($order);

        return response([
            'status' => 'success',
            'message' => 'pembeli',
            'data' => $res
        ]);
    }
}
