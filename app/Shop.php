<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['shop_id', 'shop_name', 'avatar', 'address', 'description'];
}
