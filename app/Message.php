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

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->format('H.i');
    }

    // relation
    public function user()
    {
        return $this->belongsTo(User::class, 'from');
    }
}
