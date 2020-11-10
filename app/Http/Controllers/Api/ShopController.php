<?php

namespace App\Http\Controllers\Api;

use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ShopController extends Controller
{
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
}
