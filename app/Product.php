<?php

namespace App;

use App\Category;
use App\Shop;
use App\Traits\FormatNumber;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FormatNumber;

    protected $fillable = ['product_name', 'price', 'quantity', 'description', 'image', 'weight', 'sold', 'category_id', 'shop_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
