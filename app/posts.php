<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    protected $guarded = [];

    public function Author()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
