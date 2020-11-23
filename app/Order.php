<?php

namespace App;

use App\Cart;
use App\User;
use App\Traits\FormatNumber;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // use FormatNumber;

    protected $fillable = ['user_id', 'date', 'status', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getDateAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['date'])
            ->format('d-M-Y');
    }
}
