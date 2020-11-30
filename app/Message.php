<?php

namespace App;

use App\Traits\FormatNumber;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // use FormatNumber;

    protected $fillable = [
        'from', 'to', 'message', 'is_read'
    ];

    public function users()
    {
        return $this->hasOne(User::class);
    }
    
    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
    public function toContact()
    {
        return $this->hasOne(User::class, 'id', 'to');
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->format('d-M-y, H.i');
    }
}
