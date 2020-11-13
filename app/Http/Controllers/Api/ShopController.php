<?php

namespace App\Http\Controllers\Api;

use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;

class ShopController extends Controller
{
    public function index($id)
    {
        $data = Shop::find($id);

        if ($data == false) {
            return $this->SendResponse('failed', 'Data not found', null, 500);
        }

        return $this->SendResponse('success', 'Data loaded successfully', $data, 200);
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'shop_name' => 'required|min:6|unique:shops',
            'avatar' => 'required|image|file|max:2000',
            'address' => 'required',
            'description' => 'required'
        ]);

        $image = base64_encode(file_get_contents($request->avatar));

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

        $data = Shop::create([
            'id' =>  Auth::id(),
            'shop_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'avatar' =>  $hasil->image->display_url,
            'address' => $request->address,
            'description' => $request->description
        ]);

        return $this->SendResponse('success', 'Data created successfully', $data, 201);
    }

    public function update(Request $request, Client $client, $id)
    {
        $shop = Shop::find($id);

        if ($shop === false) {
            return $this->SendResponse('failed', 'Data not found', null, 400);
        }

        $request->validate([
            'avatar'  => 'max:2000',
            'description' => 'required'
        ]);

        $image = base64_encode(file_get_contents($request->avatar));

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

        $data = $shop->update([
            'image' => $hasil->image->display_url,
            'address' => $request->quantity,
            'description' => $request->description,
        ]);

        return $this->SendResponse('success', 'Data berhasil diubah', $data, 201);
    }
}
