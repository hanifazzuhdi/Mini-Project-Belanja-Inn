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
        $categories = Category::all('id', 'category_name');

        $data = [
            'products' => $products,
            'categories' => $categories
        ];

        try {
            return $this->SendResponse('succes', 'Data success to loaded', $data, 200);
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

    public function showCategory(Category $category, $category_id)
    {
        $products = ProductResource::collection($category->where('id', $category_id)->get());

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data success to loaded', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to loaded', null, 500);
    }

    public function search(Request $request)
    {
    }
}
