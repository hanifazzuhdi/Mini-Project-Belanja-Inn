<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function category()
    {
        $categories = Category::get();

        return view('pages.settings.category', compact('categories'));
    }

    public function admins()
    {
        $datas = User::where('role_id', 3)->get();

        return view('pages.settings.admins', compact('datas'));
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'name'      => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'avatar' => 'file|image'
        ]);

        if ($request->avatar) {

            $avatar = base64_encode(file_get_contents($request->avatar));

            $res = $client->request('POST', 'https://freeimage.host/api/1/upload', [
                'form_params' => [
                    'key' => '6d207e02198a847aa98d0a2a901485a5',
                    'action' => 'upload',
                    'source' => $avatar,
                    'format' => 'json'
                ]
            ]);

            $get = $res->getBody()->getContents();

            $hasil = json_decode($get);
        }

        User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'role_id' => 3,
            'address' => $request->address,
            'avatar' => $request->avatar ? $hasil->image->display_url : 'https://iili.io/FqzDMX.md.png'
        ]);

        return redirect(route('admins'))->withSuccess('Data Created Successfully');
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect(route('category'))->withSuccess('Data Deleted Successfully');
    }
}
