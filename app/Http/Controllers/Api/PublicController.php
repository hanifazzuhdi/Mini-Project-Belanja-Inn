<?php

namespace App\Http\Controllers\Api;

use App\Shop;
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
        $srtproducts = $products->sortByDesc('id');
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
        if ($request->keyword == null) {
            return $this->SendResponse('failed', 'There is no input in search box', null, 400);
        };

        $filters = $request->filterBy;

        $products = Product::when($request->keyword, function ($query) use ($request) {
            $query->where('product_name', 'like', "%{$request->keyword}%")
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('category_name', 'like', "%{$request->keyword}%");
                });
        })->join('shops', 'products.shop_id', '=', 'shops.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'shops.shop_name', 'categories.category_name')
            ->get();


        /* On testing */
        /* filters = ['price', 'quantity', 'weight', 'sold', 'order_by'] */
        dd($products->where('product_name', 'Energen rasa milo'));




        /* On testing */

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to load', null, 500);
    }

    public function filterSearch(Request $request)
    {
        // foreach($filters as $key => $value) {
        //     $filter[] = $filters[$key];
        // }
        $products = Product::query()->when(request('filterBy'), function ($query) use ($request) {
            $filters = $request->filterBy;
            foreach ($filters as $key => $value) {
                $store[] = $query->where("$filters[$key]", 'like', "%{$request->keyword}%");
            }
            dd($store);
            return $store;
        })->get();

        dd($products);
    }

    // public function search(Request $request)
    // {
    //     if($request->keyword == null ) {
    //         return $this->SendResponse('failed', 'There is no input in search box', null, 400);
    //     };

    //     $products = Product::when($request->keyword, function ($query) use ($request) {
    //         $query->where('product_name', 'like', "%{$request->keyword}%")
    //                 ->orWhereHas('category', function($query) use ($request) {
    //                     $query->where('category_name', 'like', "%{$request->keyword}%");
    //                 });
    //             })->join('shops', 'products.shop_id', '=', 'shops.id')
    //             ->join('categories', 'products.category_id', '=', 'categories.id')
    //             ->select('products.*', 'shops.shop_name', 'categories.category_name')
    //     ->get();

    //     /* On testing */
    //     /* filters = ['price', 'quantity', 'weight', 'sold', 'order_by'] */
    //     $filters = $request->filterBy;
    //     // dd($filters['price']['comparison']);
    //     // // $products = json_decode(json_encode($products), true);
    //     // $products->when($request->filterBy['price'], function($q) use ($filters) {
    //     //     return $q->where('price', "{$filters['price']['comparison']}", "{$filters['price']['number']}");
    //     // });
    //     // dd($filters);
    //     $products->when($request->filterBy['sold'], function($q) use ($filters) {
    //         return $q->where('sold', , "{$filters['sold']}");
    //     });

    //     /* On testing */

    //     if (count($products) != 0) {
    //         return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
    //     } else return $this->SendResponse('failed', 'Data failed to load', null, 500);
    // }


}
