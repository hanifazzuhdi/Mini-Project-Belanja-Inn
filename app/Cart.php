<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_id', 'order_id', 'quantity', 'total_price'];
    
    public function product() 
    {
        return $this->belongsTo(Product::class);
    }

    public function order() 
    {
        return $this->belongsTo(Order::class);
    }
    
}
