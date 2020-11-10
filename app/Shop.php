<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Shop extends Model
{
    protected $fillable = ['id', 'shop_id', 'shop_name', 'avatar', 'address', 'description'];

    protected $hidden = ['updated_at', 'id'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
