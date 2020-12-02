<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['event_name', 'end_event', 'image'];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->format('d-m-Y H:i');
    }

    public function getEndEventAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['end_event'])
            ->format('Y-m-d');
    }
}
