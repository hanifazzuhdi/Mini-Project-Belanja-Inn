<?php

namespace App\Http\Controllers\Api;

use App\Shop;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class SellerController extends Controller
{
    public function shop()
    {
    }

    public function createShop(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|min:6',
            // 'avatar' => 'required|image|file',
            'address' => 'required',
            'description' => 'required'
        ]);

        // Validate Image
        // $image = Auth::user()->name . time() . $request->avatar->getClientOriginalExtension();
        // $request->avatar->move(public_path('image', $image));

        Shop::create([
            'shop_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'avatar' => $request->avatar,
            'address' => $request->address,
            'description' => $request->description
        ]);

        return response([
            'status' => 'success',
            'message' => 'Toko Berhasil Dibuat'
        ], 201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|min:10|max:60',
            'price'        => 'required',
            'quantity'     => 'required|integer',
            'description'  => 'required|min:20|max:2000',
            'image'        => 'required|file|image',
            'sub_image1'   => 'file|image',
            'sub_image2'   => 'file|image',
            'category_id'  => 'required'
        ]);

        $image =  Shop::find(Auth::id())->shop_name . time() . $request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('image', $image));

        $sub_image1 = 'sub1-' . Shop::find(Auth::id())->shop_name . time() . $request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('image', $image));

        $sub_image2 = 'sub1-' . Shop::find(Auth::id())->shop_name . time() . $request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('image', $image));

        Product::create([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $image,
            'sub' => $request->product_name,
            'sub_image1' => $sub_image1,
            'sub_image2' => $sub_image2,
            'category_id' => $request->category_id,
            'shop_id' => Auth::id(),
        ]);

        return response([]);
    }
}
