<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name', 'image'];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
