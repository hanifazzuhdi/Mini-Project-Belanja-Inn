<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function order(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        if (!Auth::user()) {
            return $this->sendResponse('failed', 'This Account has deleted by Admin', null, 404);
        }

        $user = Auth::user()->id;

        // cek id produk
        if (!$product) {
            return $this->SendResponse('failed', 'Product not found', null, 404);
        }

        // Cek pembeli apakah sebagai penjual
        if ($product->shop_id == $user) {
            return $this->SendResponse('failed', 'You cant buy your own goods', null, 400);
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

        // return $old_order;

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
            $new_cart->status = $saved_order->status;
            $new_cart->quantity = $request->quantity;
            $new_cart->total_price = (int) $request->quantity * (int) $product->price;
            $new_cart->save();
        } else {
            //jika keranjang lama masih ada update order lama

            //tambahkan jumlah order
            $qty = $old_carts->quantity += (int) $request->quantity;

            if ($qty > $product->quantity) {
                return $this->SendResponse('failed', 'The amount of stock is not sufficient for the demand', null, 400);
            }

            //harga sekarang
            $new_price = (int) $product->price * (int) $request->quantity;
            $old_carts->total_price = $old_carts->total_price + $new_price;
            $old_carts->update();
        }

        // $update_order = Order::where('user_id', Auth::id())->where('status', 0)->first();
        $update_price = (int) $product->price * (int) $request->quantity;
        $saved_order->total_price += $update_price;
        $saved_order->update();

        $data = new OrderResource($saved_order);

        try {
            return $this->SendResponse('succes', 'Data created successfully', $data, 202);
        } catch (\Throwable $e) {
            return $this->SendResponse('failed', 'Data failed to create', null, 500);
        }
    }

    public function carts()
    {
        $order = Order::where('user_id', Auth::id())->where('status', 0)->first('id');

        if (empty($order)) {
            return $this->SendResponse('failed', 'Data not found', null, 404);
        }

        $carts = new Cart;
        $carts->where('order_id', $order->id)
            ->whereHas('product', function ($query) {
                $query->where('quantity', 0);
            })->delete();
        $carts->refresh();
        $carts = $carts->where('order_id', $order->id)
            ->with(['product:id,product_name,price,image,weight,quantity', 'shop:id,shop_name'])
            ->get();
        $new_total_price = $carts->sum('total_price');
        $order->update(['total_price' => $new_total_price]);
        $carts = $carts->toArray();

        $data = collect($carts)->map(function ($value, $key) {
            $value['total_price'] = number_format($value['total_price'], 0, ',', '.');
            $value['product']['price'] = number_format($value['product']['price'], 0, ',', '.');
            unset($value['shop_id']);
            unset($value['product_id']);
            return $value;
        });

        return $this->SendResponse('succes', 'Data fetched successfully', $data, 200);
    }

    public function updateCart(Request $request, $cart_id)
    {
        $cart = Cart::where('id', "{$cart_id}")->first();
        $product = Product::where('id', "{$cart->product_id}")->first();

        if ($request->quantity != $cart->quantity && $request->quantity != 0) {
            $order = Order::where('id', "{$cart->order_id}")->first();

            $query = Cart::query();

            $total_price = (int) $query->where('order_id', "{$cart->order_id}")->sum('total_price');

            $update = $query->when(function ($request) use ($product) {
                if ($request->quantity <= $product->quantity) {
                    return true;
                } else $this->SendResponse('succes', 'The product quantity is not sufficient', null, 404);
            }, function ($query) use ($request, $cart, $product, $order, $total_price) {
                $query->where('id', "{$cart->id}")->with('order:id,total_price')->update([
                    'quantity' => $request->quantity,
                    'total_price' => $request->quantity * $product->price,
                ]);

                $order->update(['total_price' => ($request->quantity * $product->price) + $total_price]);
                return $query->where('oder_id', "{$order->id}")
                    ->with(['product:id,product_name,price,image,weight,quantity', 'shop:id,shop_name']);
            })->get();
            return $this->SendResponse('succes', 'Data updated successfully', $update, 200);
        } elseif ($request->quantity == 0) {
            $this->delete($cart_id);
        } else {
            return $this->SendResponse('failed', 'No change have been made', null, 200);
        }
    }

    public function delete($id)
    {
        $cart = Cart::where('id', $id)->first();

        $order = Order::where('id', $cart->order_id)->first();

        $order->total_price = $order->total_price - $cart->total_price;
        $order->update();

        $cart->delete();

        $carts = Cart::where('order_id', $order->id)->get();

        if (count($carts) == 0) {
            $order->delete();
        }

        try {
            return $this->SendResponse('succes', 'Data deleted successfully', $cart, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data not found or has been deleted', null, 500);
        }
    }
}
