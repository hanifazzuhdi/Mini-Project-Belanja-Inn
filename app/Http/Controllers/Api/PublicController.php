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
        $srtproducts = $products->sortByDesc('created_at');
        $products = $srtproducts->values()->all();

        try {
            return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to load', null, 500);
        }
    }

    public function show(Product $products, $id)
    {
        $product = new ProductResource($products->find(($id)));

        try {
            return $this->SendResponse('succes', 'Data loaded successfully', $product, 200);
        } catch (\Throwable $th) {
            return $this->SendResponse('failed', 'Data failed to load', null, 500);
        }
    }

    public function showCategory(Product $product, $category_id)
    {
        $products = ProductResource::collection($product->where('category_id', $category_id)->get());

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to load', null, 500);
    }

    public function search(Request $request)
    {
        $products = Product::when($request->keyword, function ($query) use ($request) {
            $query->where('product_name', 'like', "%{$request->keyword}%");
        })->get();

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to load', null, 500);
    }
}
