<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products = ProductResource::collection($products);
        try {
            return $this->SendResponse('succes', 'Data berhasil di dapat', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('gagal', 'Data gagal di dapat', null, 500);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $products, $id)
    {
        $products = new ProductResource($products->find(($id)));

        try {
            return $this->SendResponse('succes', 'Data berhasil di dapat', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('gagal', 'Data gagal di dapat', null, 500);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
