<?php

namespace App\Http\Controllers\Api;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserAuth(User $user)
    {
        $data = new UserResource($user->find(Auth::id()));

        return $this->SendResponse('success', 'Data loaded', [$data], 200);
    }

    public function updatePassword(Request $request)
    {
        // cek apakah dia admin tidak boleh ganti dari sini
        $cekAdmin  = Auth::user()->role_id;

        if ($cekAdmin == 3) {
            return response([
                'status' => 'failed',
                'message' => "You don't have permission"
            ], 400);
        }

        $data = User::find(Auth::id());

        $request->validate([
            'password' => 'required'
        ]);

        $data->update([
            'password' => bcrypt($request->password)
        ]);

        return response([
            'status' => 'success',
            'message' => 'Password changed successfully'
        ], 200);
    }

    public function update(Request $request, Client $client)
    {
        // cek apakah dia admin tidak boleh ganti dari sini
        $cekAdmin  = Auth::user()->role_id;

        if ($cekAdmin == 3) {
            return response([
                'status' => 'failed',
                'message' => "You don't have permission"
            ], 400);
        }

        $data = User::find(Auth::id());

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'avatar' => 'file|image'
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

            $newAvatar = $hasil->image->display_url;
        }

        $data->update([
            'name' => $request->name ? $request->name : $data->name,
            'phone_number' => $request->phone_number ? $request->phone_number : $data->phone_number,
            'address' => $request->address ? $request->address : $data->address,
            'avatar' => $request->avatar ? $newAvatar : $data->avatar,
        ]);

        return response([
            'status' => 'success',
            'message' => 'Profile changed successfully'
        ], 200);
    }
}
