<?php

namespace App\Http\Controllers\Api;

use App\Shop;
use App\Product;
use App\Category;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function index()
    {
        $product = Product::where('quantity', '!=', 0)->get();

        $products = ProductResource::collection($product);
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
        $products = ProductResource::collection($product->where('category_id', $category_id)->where('quantity', '!=', 0)->get());

        if (count($products) != 0) {
            return $this->SendResponse('succes', 'Data loaded successfully', $products, 200);
        } else return $this->SendResponse('failed', 'Data failed to load', null, 500);
    }

    public function search(Request $request)
    {
        /* filters = ['price', 'Ready Stock', 'sort_by'] */
        $filters = $request->filterBy;

        $query = Product::query();
        $query->when(!empty($filters['sort_by']) && $filters['sort_by'] == 'terbaru', function ($query) {
            return $query->latest();
        });

        $products = $query->when($request->keyword, function ($query) use ($request) {
            return $query->where(DB::raw("lower('product_name')"), 'like', "%" . strtolower($request->keyword) . "%")
                ->orWhereHas('category', function ($query) use ($request) {
                    return $query->where(DB::raw("lower('category_name')"), 'like', "%" . strtolower($request->keyword) . "%");
                });
        })
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'shops.shop_name', 'categories.category_name')
            ->get()
            ->toArray();

        $products = collect($products);

        if (!empty($filters)) {
            /* price range */
            // costum price range
            $pr4 = null;
            if (!empty($filters['price']['range']) && is_array($filters['price']['range'])) {
                $pr4 = [(int) $filters['price']['range']['top'], (int) $filters['price']['range']['bottom']];
            }

            $pr = [
                'pr1' => [0, 75000],
                'pr2' => [75000, 150000],
                'pr3' => [150000, 200000],
                'pr4' => $pr4
            ];

            $sort_by = [
                'terlaris' => ['sold', true],
                'termahal' => ['price', true],
                'termurah' => ['price', false]
            ];

            if (!empty($filters['price']['range']) && is_string($filters['price']['range'])) {
                $products = $products->whereBetween('price', $pr["{$filters['price']['range']}"]);
            } elseif (!empty($filters['price']['range'])) {
                $products = $products->whereBetween('price', $pr['pr4']);
            }

            if (!empty($filters['stock_status']) && $filters['stock_status'] == 'ready') {
                $products = $products->where('quantity', '>', 0);
            }

            if (!empty($filters['sort_by']) && $filters['sort_by'] != 'terbaru') {
                if (Arr::exists($sort_by, $filters['sort_by'])) {
                    $key = $sort_by["{$filters['sort_by']}"][0];
                    $sortmode = $sort_by["{$filters['sort_by']}"][1];
                    $products = $products->sortBy($key, SORT_REGULAR, $sortmode); // parameter ke 3 [true => descending, false => ascending]
                }
            }

            /* filters end */
        }
        $products = $products->map(function ($value, $key) {
            $value['price'] = number_format($value['price'], 0, ',', '.');
            return $value;
        });

        $data = $products->values()->all();

        if (count($data) != 0) {
            return $this->SendResponse('succes', 'Data loaded successfully', $data, 200);
        } else return $this->SendResponse('failed', 'No data matches the search terms', null, 404);
    }
}


/* Note: map()
    map method is used to iterate through the full collection. It accepts a callback as an argument.
    value and the key is passed to the callback. Callback can modify the values and return them.
    Finally, a new collection instance of modified items is returned.
*/
