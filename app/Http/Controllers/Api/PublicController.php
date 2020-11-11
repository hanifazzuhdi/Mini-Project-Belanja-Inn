<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class PublicController extends Controller
{
    public function index()
    {
        $products = ProductResource::collection(Product::all());

        try {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
        }
    }

    public function show(Product $products, $id)
    {
        $product = new ProductResource($products->find(($id)));

        try {
            return $this->SendResponse('succes', 'Data success to loaded', $product, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
        }
    }

    public function showCategory(Product $product, $category_id)
    {
<<<<<<< HEAD
        $product = ProductResource::collection($product->where('category_id', $category_id)->get());

        if (count($product) != 0) {
            return $this->SendResponse('succes', 'Data success to loaded', $product, 200);
=======
        $products = ProductResource::collection($product->where('category_id', $category_id)->get());

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
>>>>>>> c2da3db4011dd35f327392f7cb27f093b593a29d
        } else return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
    }

    public function search(Request $request)
    {
    }
}
