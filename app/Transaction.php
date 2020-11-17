<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = ['cart_id', 'order_id'];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
