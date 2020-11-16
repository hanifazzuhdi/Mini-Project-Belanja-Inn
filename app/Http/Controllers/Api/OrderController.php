<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function showProduct($id)
    {
        $product = Product::where('id', $id)->first();
        
        try {
            return $this->SendResponse('succes', 'Data loaded successfully', $product, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to load', null, 500);
        }
    }

    public function order(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        //validasi jumlah stock
        if($request->order_quantity > $product->quantity) {
            return $this->SendResponse('failed', 'The amount of stock is not sufficient for the demand', null, 400);           
        }

        //cek order lama yang belum di check out
        $old_order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        
        if(empty($old_order)) {
            //jika tidak ada order lama maka buat order baru
            $order = new Order;
            $order->user_id = Auth::id();
            $order->date = now();
            $order->status = 0;
            $order->total_price = 0;
            $order->save();
        }

        //cek order di database yang belum di checkout (status == 0), order lama ataupun baru
        $saved_order = Order::where('user_id', Auth::id())->where('status', 0)->first();

        //cek apakah sudah ada pesanan dengan product yang sama di keranjang 
        $old_carts = Cart::where('product_id', $product->id)->where('order_id', $saved_order->id)->first();

        if(empty($old_carts)) {
            //jika tidak ada keranjang dengan order_id dan produk(yang di order sekarang), buat keranjang baru
            $new_cart = new Cart;
            $new_cart->product_id = $product->id;
            $new_cart->order_id = $saved_order->id;
            $new_cart->quantity = $request->quantity;
            $new_cart->total_price = (int) $request->quantity * (int) $product->price;
            $new_cart->save();
        } else {
            //jika keranjang lama masih ada update order lama
            //tambahkan jumlah order
            $old_carts->quantity =  $old_carts->quantity + (int) $request->quantity;

            //harga sekarang
            $new_price = (int) $product->price * (int) $request->quantity;
            $old_carts->total_price = (int) $old_carts->total_price + $new_price;
            $old_carts->update();
        }

        $update_order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        $update_order->total_price = (int) $update_order->total_price + (int) $product->price * (int) $request->quantity;
        $update_order->update();
        
        $data = new OrderResource($update_order);

        try {
            return $this->SendResponse('succes', 'Data created successfully', $data, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to create', null, 500);
        }
    }

    public function delete($id) 
    {
        $cart = Cart::where('id', $id)->first();

        $order = Order::where('id', $cart->order_id)->first();
 
        $order->total_price = $order->total_price - $cart->total_price;
        $order->update();

        $cart->delete();

        try {
            if(empty($cart))
            return $this->SendResponse('succes', 'Data deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to delete', $cart, 500);
        }
    }
    

}
