<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quiz_attempts extends Model
{
    protected $guarded = [];

    public function Quiz()
    {
        return $this->hasOne('App\quizes','id','quiz_id');
    }

}
