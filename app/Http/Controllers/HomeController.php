<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $active = DB::select("SELECT COUNT(id) as active FROM users WHERE role_id != 3");
        $shop = DB::select("SELECT COUNT(id) as shop FROM users WHERE role_id = 2 ");

        return view('pages.dashboard', compact('active', 'shop'));
    }

    public function getUser()
    {
        $datas = User::where('role_id', '!=', 3)->orderBy('id')->get()->toArray();

        return view('pages.daftarUser', compact('datas'));
    }

    public function getDetail($id)
    {
        $data = User::find($id)->toArray();

        return view('pages.detailUser', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'password' => $request->password ? $request->password : $user->password,
            'address' => $request->address,
            'phone_number' => $request->phone_number
        ]);

        return redirect("detailUser/$id")->with('status', 'Data Updated Successfully');
    }

    public function updateAvatar($id, Request $request, Client $client)
    {
        $request->validate([
            'avatar' => 'required|file|image|max:2000'
        ]);

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

        $newAvatar = $hasil->image->display_url;

        DB::update("UPDATE users SET avatar = '$newAvatar' WHERE id = $id");

        return redirect("detailUser/$id")->with('status', 'Avatar has been changed');
    }

    public function destroy($id)
    {
        Product::where('shop_id', $id)->delete();

        Shop::destroy($id);

        User::destroy($id);

        return redirect(route('getUser'))->with('status', 'Data Deleted Successfully');
    }

    public function category()
    {
        $categories = Category::all()->toArray();

        return view("pages.category", compact('categories'));
    }
}
