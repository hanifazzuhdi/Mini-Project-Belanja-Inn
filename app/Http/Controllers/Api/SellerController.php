<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Shop;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function store(Request $request, Client $client)
    {
        // Cek jika dia tidak memiliki toko
        $cek = Shop::find(Auth::id());

        if (empty($cek)) {
            return $this->SendResponse('failed', "You don't have permission to create product", null, 400);
        }

        // validate
        $request->validate([
            'product_name' => 'required|min:10|max:60',
            'price'        => 'required',
            'quantity'     => 'required|integer',
            'description'  => 'required|min:10|max:2000',
            'image'        => 'required|file|image',
            'category_id'  => 'required'
        ]);

        // Validasi image
        $image = base64_encode(file_get_contents($request->image));
        $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
            'form_params' => [
                'key' => '6d207e02198a847aa98d0a2a901485a5',
                'action' => 'upload',
                'source' => $image,
                'format' => 'json'
            ]
        ]);

        $get = $res->getBody()->getContents();

        $hasil = json_decode($get);

        $product = Product::create([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $hasil->image->display_url,
            'weight' => $request->weight,
            'shop_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return $this->SendResponse('success', 'Product created successfully', $product, 201);
    }

    public function update(Request $request, Client $client, $id)
    {
        // cek jika dia bukan pemilik toko dan produk yang dicari tidak ada
        $product = Product::where('id', $id)->where('shop_id', Auth::id())->first();

        if (empty($product)) {
            return $this->SendResponse('failed', "You don't have permission to update this product", null, 400);
        }

        // validasi
        $request->validate([
            'product_name' => 'required|min:10|max:60',
            'price'        => 'required',
            'quantity'     => 'required|integer',
            'description'  => 'required|min:10|max:2000',
            'image'        => 'file|image',
        ]);

        // Validasi image
        if ($request->image) {
            $image = base64_encode(file_get_contents($request->image));

            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $image,
                    'format' => 'json'
                ]
            ]);

            $get = $res->getBody()->getContents();

            $hasil = json_decode($get);

            $newImage = $hasil->image->display_url;
        } else {
            $newImage = $product->image;
        }

        $data = $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $newImage,
        ]);

        return $this->SendResponse('success', 'Product updated successfully', $data, 200);
    }

    public function destroy($id)
    {
        // jika dia bukan pemilik toko dan id yang dicari tidak ada
        $product = Product::where('id', $id)->where('shop_id', Auth::id())->first();

        if (empty($product)) {
            return $this->SendResponse('failed', "You don't have permission to delete this product", null, 400);
        }

        // hapus keranjang dengan yang memiliki produk berkait
        Cart::where('product_id', $id)->delete();

        $data = Product::destroy($id);

        if ($data) {
            return response([
                'status' => 'success',
                'message' => 'Your product deleted successfully'
            ], 200);
        } else {
            return $this->SendResponse('failed', 'Error salahkan backend', null, 500);
        }
    }
}
