<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Order;
use App\Product;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    // Function Get
    public function index()
    {
        $active = DB::select("SELECT COUNT(id) as active FROM users WHERE role_id != 3");
        $shop = DB::select("SELECT COUNT(id) as shop FROM users WHERE role_id = 2 ");
        $total_transaction = DB::table('orders')->where('status', 1)->count('id');
        $transaction = DB::table('orders')->where('status', 1)->sum('total_price');

        $histories = Order::with('user')->get();
        return view('pages.dashboard', compact('active', 'shop', 'total_transaction', 'transaction', 'histories'));
    }

    public function user()
    {
        $datas = User::where('role_id', '!=', 3)->orderByDesc('id')->get();

        return view('pages.daftarUser', compact('datas'));
    }

    public function product()
    {
        $datas = Product::with('shop')->orderByDesc('id')->get();

        return view('pages.daftarProduct', compact('datas'));
    }

    // Function Get Detail
    public function getDetail($id)
    {
        $data = User::find($id);

        return view('pages.detailUser', compact('data'));
    }

    public function getProductDetail($id)
    {
        $data = Product::with('shop')->find($id);

        return view('pages.detailProduct', compact('data'));
    }

    public function getHistory($id)
    {
        $data = Cart::with('order')->with('product')->where('order_id', $id)->get();

        return view('pages.detailHistory', compact('data'));
    }

    // Function Update
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
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

    // Function Destroy
    public function destroy($id)
    {
        Product::where('shop_id', $id)->delete();

        Shop::destroy($id);

        User::destroy($id);

        return redirect(route('user'))->with('status', 'Data Deleted Successfully');
    }

    public function destroyProduct($id)
    {
        Product::destroy($id);

        return redirect(route('product'))->with('status', 'Data Deleted Successfully');
    }
}
