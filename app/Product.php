<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name', 'price', 'quantity', 'description', 'image', 'sub_image1', 'sub_image2', 'category_id', 'shop_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
