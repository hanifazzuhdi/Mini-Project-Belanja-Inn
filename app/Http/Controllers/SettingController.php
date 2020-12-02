<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use App\Category;
use App\Event;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function category()
    {
        $categories = Category::all();

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
            'avatar' => $request->avatar ? $hasil->image->display_url : 'https://via.placeholder.com/150'
        ]);

        return redirect(route('admins'))->withSuccess('Data Created Successfully');
    }

    public function storeCategory(Request $request, Client $client)
    {
        $request->validate([
            'category_name' => 'required',
            'image'         => 'required|image|file'
        ]);

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
        }

        Category::create([
            'category_name' => $request->category_name,
            'image' => $hasil->image->display_url
        ]);

        return redirect(route('admins'))->withSuccess('Data Created Successfully');
    }

    public function destroy($id)
    {
        // Hapus produk id category terkait
        $products = Product::where('category_id', $id)->get();

        foreach ($products as $product) {
            // Hapus keranjang id category terkait
            $carts = Cart::where('product_id', $product->id)->get();

            foreach ($carts as $cart) {
                # code...
                $cart->delete();
            }

            $product->delete();
        }

        Category::destroy($id);

        return redirect(route('category'))->withSuccess('Data Deleted Successfully');
    }


    // CONTROLLER EVENT
    public function event()
    {
        // Query hapus otomatis event
        // DB::delete('DELETE FROM events WHERE DATEDIFF(CURDATE(), end_event) >= 1');

        $events = Event::all();

        return view('pages.settings.event', compact('events'));
    }

    public function storeEvent(Request $request, Client $client)
    {
        $request->validate([
            'event_name' => 'required',
            'image'      => 'required|file|image',
            'end_event'   => 'required|date'
        ]);

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
        }

        Event::create([
            'event_name' => $request->event_name,
            'image'      => $hasil->image->display_url,
            'end_event'   => $request->end_event
        ]);

        return redirect(route('event'))->withSuccess('Data Created Successfully');
    }

    public function destroyEvent($id)
    {
        $data = Event::destroy($id);

        if ($data)
            return redirect(route('event'))->withSuccess('Data Deleted Successfully');
    }
}
