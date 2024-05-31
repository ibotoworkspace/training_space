<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    protected $guarded = [];

    public function quiz()
    {
        return $this->hasOne('App\quizes','id','quiz_id');
    }
}
