<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Category;
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
        $product = new ProductResource($products->find($id));

        try {
            return $this->SendResponse('succes', 'Data loaded successfully', [$product], 200);
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
        if($request->keyword == null ) {
            return $this->SendResponse('failed', 'There is no input in search box', null, 400);
        };

        $products = Product::when($request->keyword, function ($query) use ($request) {
            $query->where('product_name', 'like', "%{$request->keyword}%")
                    ->orWhereHas('category', function($query) use ($request) {
                        $query->where('category_name', 'like', "%{$request->keyword}%");
                    });
        })->get();

        if(isset($request->filter)) {

        }

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to load', null, 500);
    }

    public function filterSearch(Request $request)
    {   
      
        var_dump($request->filterBy); die;
        
        $products = Product::query()->when($request('filterBy'), function ($query) use ($request) {
            return $query->where("product_name", 'like', "%{$request->keyword}%"); 
        })->get();

    }


}

