<?php

namespace App;

use App\Traits\FormatNumber;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use FormatNumber;

    protected $fillable = ['shop_id', 'product_id', 'order_id', 'quantity', 'total_price'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    
}
