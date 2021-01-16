<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Shop;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResource;

class ShopController extends Controller
{
    public function index($id)
    {
        $data = Shop::find($id);

        if ($data == false) {
            return $this->SendResponse('failed', 'Data not found', null, 404);
        }

        $res = new ShopResource($data);

        return response([
            'status' => 'success',
            'message' => 'Data loaded successfully',
            'hasil' => $res
        ]);
    }

    public function store(Request $request, Client $client)
    {
        // Cek tidak boleh memiliki toko ganda
        $cek = Shop::where('id', Auth::id())->first();

        if (!empty($cek)) {
            return response([
                'status' => 'failed',
                'message' => 'Your account already has a shop '
            ], 404);
        }

        $request->validate([
            'shop_name' => 'required|min:6|unique:shops',
            'avatar' => 'required|image|file',
            'address' => 'required',
            'description' => 'required'
        ]);

        if ($request->avatar) {
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

            $avatar = $hasil->image->display_url;
        } else {
            $avatar = NULL;
        }

        $data = Shop::create([
            'id' =>  Auth::id(),
            'user_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'avatar' =>  $avatar,
            'address' => $request->address,
            'description' => $request->description
        ]);

        // update role user
        $user = User::find(Auth::id());

        $user->update([
            'role_id' => 2
        ]);

        return $this->SendResponse('success', 'Shop created successfully', $data, 201);
    }

    public function update(Request $request, Client $client)
    {
        $id = Auth::id();

        $shop = Shop::find($id);

        // cek bila tidak ada toko
        if (empty($shop)) {
            return $this->SendResponse('failed', "You don't have a shop on this account", null, 404);
        }

        $request->validate([
            'avatar'  => 'file|image',
            'address' => 'required',
            'description' => 'required'
        ]);

        // cek gambar
        if ($request->avatar) {
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

            $newAvatar = $hasil->image->display_url;
        } else {
            $newAvatar = $shop->avatar;
        }

        $data = $shop->update([
            'avatar' => $newAvatar,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return $this->SendResponse('success', 'Shop updated successfully', $data, 200);
    }
}
