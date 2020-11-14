<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class SellerController extends Controller
{
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'product_name' => 'required|min:10|max:60',
            'price'        => 'required',
            'quantity'     => 'required|integer',
            'description'  => 'required|min:20|max:2000',
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

        // Format Harga
        $format = number_format($request->price, 2, ',', '.');

        $explode = explode(",", $format);
        $price = $explode[0];


        $product = Product::create([
            'product_name' => $request->product_name,
            'price' => $price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $hasil->image->display_url,
            'weight' => $request->weight,
            'shop_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return $this->SendResponse('success', 'Produk berhasil ditambahkan', $product, 201);
    }

    public function update(Request $request, Client $client, $id)
    {
        $product = Product::find($id);

        if ($product === false) {
            return $this->SendResponse('failed', 'Produk tidak ditemukan', null, 400);
        }

        $request->validate([
            'product_name' => 'required|min:10|max:60',
            'price'        => 'required',
            'quantity'     => 'required|integer',
            'description'  => 'required|min:10|max:2000',
            'image'        => 'file|image',
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

        // Format harga
        $format = number_format($request->price, 2, ',', '.');

        $explode = explode(",", $format);
        $price = $explode[0];

        $data = $product->update([
            'product_name' => $request->product_name,
            'price' => $price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $hasil->image->display_url,
            'weight' => $request->weight
        ]);

        return $this->SendResponse('success', 'Produk berhasil diubah', $data, 201);
    }

    public function destroy($id)
    {
        $data = Product::destroy($id);

        if ($data) {
            return response([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ], 200);
        } else return $this->SendResponse('failed', 'Produk gagal dihapus', null, 404);
    }
}
