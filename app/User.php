<?php

namespace App;

use App\Traits\FormatNumber;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use FormatNumber;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'phone_number', 'address', 'role_id', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function messageFrom()
    {
        return $this->hasMany(Message::class, 'from', 'id');
    }
    public function messageTo()
    {
        return $this->hasMany(Message::class, 'to', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
