<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class CheckoutController extends Controller
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
            'message' => 'Data transaction loaded',
            'data' => $order,
            'products' => $hasil
        ], 200);
    }

    public function checkout()
    {
        // ubah status menjadi 1 (1 = sudah checkout) + transaction_id
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        if (empty($order)) {
            return $this->SendResponse('failed', 'Data order not found', null, 404);
        }

        // update status order
        $order->status = 1;
        $order->update();

        $order_id = $order->id;

        $carts = Cart::where('order_id', $order_id)->get();

        foreach ($carts as $cart) {
            // update status cart
            $cart->status = 1;
            $cart->update();

            // kurangi stok barang + tambah terjual
            $product = Product::where('id', $cart->product_id)->first();

            $product->quantity -= $cart['quantity'];
            $product->sold += $cart['quantity'];
            $product->update();

            $res[] = $product;
        }

        return response([
            'status' => 'success',
            'message' => 'Order success',
            'data' => $res
        ], 200);
    }
}
