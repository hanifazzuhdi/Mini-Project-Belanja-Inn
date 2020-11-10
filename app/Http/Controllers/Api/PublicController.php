<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Category;
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

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
    }

    public function search(Request $request)
    {
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
    }
}
