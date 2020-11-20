<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function order(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        $user = Auth::user()->id;

        // cek id produk
        if ($product == false) {
            return $this->SendResponse('failed', 'Product not found', null, 404);
        }

        // Cek pembeli apakah sebagai penjual
        if ($product['shop_id'] === $user) {
            return $this->SendResponse('failed', 'You cant buy your own goods', null, 400);
        }

        if ($request->quantity == null) {
            $request->quantity = '0';
        }

        //validasi jumlah stock
        if ($request->quantity > $product->quantity) {
            return $this->SendResponse('failed', 'The amount of stock is not sufficient for the demand', null, 400);
        }

        //cek order lama yang belum di check out
        $old_order = Order::where('user_id', Auth::id())->where('status', 0)->first();   // <== cari di tabel order dimana user_id = id user yang login dan yang status nya 0

        //jika tidak ada order lama maka buat order baru
        if (empty($old_order)) {
            $order = new Order;
            $order->user_id = Auth::id();
            $order->date = now();                       // <<== otomatis akan terbuat
            $order->status = 0;
            $order->total_price = 0;
            $order->save();
        }

        //cek order di database yang belum di checkout (status == 0), order lama
        $saved_order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        //cek apakah sudah ada pesanan dengan product yang sama di keranjang
        $old_carts = Cart::where('product_id', $product->id)->where('order_id', $saved_order->id)->first();

        //jika tidak ada keranjang dengan order_id dan produk(yang di order sekarang), buat keranjang baru
        if (empty($old_carts)) {
            $new_cart = new Cart;
            $new_cart->shop_id = $product->shop_id;
            $new_cart->product_id = $product->id;
            $new_cart->order_id = $saved_order->id;
            $new_cart->quantity = $request->quantity;
            $new_cart->total_price = (int) $request->quantity * (int) $product->price;
            $new_cart->save();
        } else {
            //jika keranjang lama masih ada update order lama

            //tambahkan jumlah order
            $old_carts->quantity += (int) $request->quantity;

            //harga sekarang
            $new_price = (int) $product->price * (int) $request->quantity;
            $old_carts->total_price += $new_price;
            $old_carts->update();
        }

        $update_order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        $update_price = (int) $product->price * (int) $request->quantity;
        $update_order->total_price += $update_price;
        $update_order->update();

        $data = new OrderResource($update_order);

        try {
            return $this->SendResponse('succes', 'Data created successfully', $data, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to create', null, 500);
        }
    }

    public function carts()
    {
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first('id');
        $cart = Cart::where('order_id', $order->id)->get();
        $data = CartResource::collection($cart);

        return $this->SendResponse('succes', 'Data created successfully', $data, 200);
    }

    public function delete($id)
    {
        $cart = Cart::where('id', $id)->first();

        $order = Order::where('id', $cart->order_id)->first();

        $order->total_price = $order->total_price - $cart->total_price;
        $order->update();

        $cart->delete();

        try {
            if (empty($cart))
                return $this->SendResponse('succes', 'Data deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to delete', $cart, 500);
        }
    }
}
