<?php

namespace App;

use App\Product;
use App\Traits\FormatNumber;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use FormatNumber;

    protected $fillable = ['id', 'user_id', 'shop_name', 'avatar', 'address', 'description'];

    // protected $hidden = ['updated_at', 'id'];
    
    protected static function boot() 
    {
        parent::boot();

        static::creating(function ($query) {
            $query->user_id = $query->id;
        });

    }
    

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
