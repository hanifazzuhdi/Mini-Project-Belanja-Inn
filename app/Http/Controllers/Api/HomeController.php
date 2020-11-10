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
        $products = ProductResource::collection(Product::all());

        try {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
        }
    }

    public function show(Product $products, $id)
    {
        $products = new ProductResource($products->find(($id)));

        try {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
        }
    }

    public function showCategory(Product $product, $category_id)
    {
        $products = ProductResource::collection($product->where('category_id', $category_id)->get());

        try {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data success to loaded', null, 500);
        }
    }

    public function search(Request $request)
    {
    }
}
