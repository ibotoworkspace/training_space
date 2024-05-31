<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class answers extends Model
{
    protected $guarded = [];

    public function Quiz()
    {
        return $this->hasOne('App\quizes','id','quiz_id');
    }

    public function Question()
    {
        return $this->hasOne('App\questions','id','question_id');
    }
}
