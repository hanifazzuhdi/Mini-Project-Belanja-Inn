<?php

namespace App;

use App\Product;
use App\Traits\FormatNumber;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use FormatNumber;

    protected $fillable = ['id', 'user_id', 'shop_name', 'avatar', 'address', 'description'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->user_id = $query->id;
        });
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
