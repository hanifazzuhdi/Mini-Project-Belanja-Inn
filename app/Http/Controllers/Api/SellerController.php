<?php

namespace App\Http\Controllers\Api;

use App\Shop;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function shop()
    {
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'shop_id' => 'unique:shops',
            'shop_name' => 'required|min:6|unique:shops',
            'avatar' => 'required|image|file',
            'address' => 'required',
            'description' => 'required'
        ]);

        // Validate Image
        $image = Auth::user()->name . '-' . time() . '.' . $request->avatar->getClientOriginalExtension();
        $request->avatar->storeAs('public/shops', $image);

        $data = Shop::create([
            'shop_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'avatar' =>  $image,
            'address' => $request->address,
            'description' => $request->description
        ]);

        return $this->SendResponse('success', 'Toko berhasil dibuat', $data, 201);
    }

    public function storeProduct(Request $request)
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

        $product = Product::create([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $image,
            'sub_image1' => $sub_image1,
            'sub_image2' => $sub_image2,
            'category_id' => $request->category_id,
            'shop_id' => Auth::id(),
        ]);

        return $this->SendResponse('success', 'Produk berhasil ditambahkan', $product, 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product == false) {
            return $this->SendResponse('failed', 'Produk tidak ditemukan', null, 400);
        }

        // validate image and subimage
        if ($request->avatar) {
            unlink(public_path('image', $request->avatar));

            $image =  Shop::find(Auth::id())->shop_name . time() . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('image', $image));
        }

        $data = $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $image,
            // 'sub_image1' => $sub_image1,
            // 'sub_image2' => $sub_image2,
            'category_id' => $request->category_id,
        ]);

        return $this->SendResponse('success', 'Produk berhasil ditambahkan', $data, 201);
    }
}
