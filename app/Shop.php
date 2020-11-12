<?php

namespace App;

use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['id', 'shop_id', 'shop_name', 'avatar', 'address', 'description'];

    // protected $hidden = ['updated_at', 'id'];

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

    // public function getCreatedAtAttribute()
    // {
    //     return Carbon::parse($this->attributes['created_at'])->format('l, d F Y H:i');
    // }
    
    // public function getUpdatedAtAttribute()
    // {
    //     return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    // }

}
