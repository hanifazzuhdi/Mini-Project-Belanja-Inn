<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'order_id', 'quantity', 'price', 'total_price'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    
    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
}
