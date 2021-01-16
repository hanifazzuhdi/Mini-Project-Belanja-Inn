<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role_name'];

    public $timestamps = false;

    public function users()
    {
        $this->hasMany('App\User');
    }
}
