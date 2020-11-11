<?php

namespace App\Http\Controllers\Api;

use App\Shop;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SellerController extends Controller
{
    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|min:10|max:60',
            'price'        => 'required',
            'quantity'     => 'required|integer',
            'description'  => 'required|min:20|max:2000',
            'image'        => 'required|file|image',
            'category_id'  => 'required'
        ]);

        $image =  Auth::user()->username . '-' . time() . '.' . $request->image->getClientOriginalName();
        $request->image->move(public_path('image/products'), $image);

        $product = Product::create([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $image,
            'shop_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return $this->SendResponse('success', 'Produk berhasil ditambahkan', $product, 201);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product === false) {
            return $this->SendResponse('failed', 'Produk tidak ditemukan', null, 400);
        }

        // dd($product->id);
        $request->validate([
            'product_name' => 'min:10|max:60',
            // 'price'        => ',
            'quantity'     => 'integer',
            'description'  => 'min:20|max:2000',
            'image'        => 'file|image',
        ]);

        // validate image and delete old image
        File::delete(public_path('image/products/') . $product->image);

        $image =  Auth::user()->username . '-' . time() . '.' . $request->image->getClientOriginalName();
        $request->image->move(public_path('image/products'), $image);

        $data = $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $image,
        ]);

        return $this->SendResponse('success', 'Produk berhasil diubah', $data, 201);
    }
}
