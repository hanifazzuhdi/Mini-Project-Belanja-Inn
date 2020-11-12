<?php

namespace App;

use App\Category;
use App\Shop;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name', 'price', 'quantity', 'description', 'image', 'weight', 'sold', 'category_id', 'shop_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
