<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'to', 'message', 'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
