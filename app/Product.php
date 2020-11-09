<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name', 'price', 'quantity', 'description', 'image', 'sub_image1', 'sub_image2', 'category_id', 'shop_id'];
}
