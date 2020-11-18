<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\KonfirmasiResource;
use App\Http\Resources\ShopConfirmResource;
use App\Http\Resources\TransactionResource;

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

    // fungsi untuk tampilan tunggu konfirmasi pembeli
    public function konfirmasi()
    {
        //pembeli
        $order = Order::where('user_id', Auth::id())->where('status', 1)->get()->toArray();

        if ($order == false) {
            return response([
                'status' => 'failed',
                'message' => 'data not found',
                'data' => null
            ]);
        }

        return response([
            'status' => 'success',
            'message' => 'pembeli',
            'data' => $order
        ], 200);
    }

    public function isiKonfirmasi($id)
    {
        $carts = Cart::where('order_id', $id)->get();

        $res = KonfirmasiResource::collection($carts);

        if ($carts === false) {
            return $this->SendResponse('failed', 'data not found', null, 404);
        }

        return response([
            'status' => 'success',
            'message' => 'pembeli',
            'data' => $res
        ]);
    }

    public function shopKonfirmasi()
    {
        // penjual
        $order = Cart::where('shop_id', 2)->get();

        $res = ShopConfirmResource::collection($order);

        return response([
            'status' => 'success',
            'message' => 'Data found for seller',
            'data' => $res
        ]);
    }
}
