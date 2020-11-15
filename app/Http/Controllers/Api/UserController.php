<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserAuth(User $user)
    {
        $data = new UserResource($user->find(Auth::id()));

        return $this->SendResponse('success', 'Data loaded', [$data], 200);
    }

    public function update(Request $request, Client $client)
    {
        $data = User::find(Auth::id());

        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'avatar' => 'required'
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

        $data->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'avatar' => $hasil->image->display_url
        ]);

        return response([
            'status' => 'success',
            'message' => 'Profile berhasil diubah'
        ], 202);
    }
}
