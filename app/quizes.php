<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quizes extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->hasOne('App\Course','id','course_id');
    }

    public function questions()
    {
        return $this->hasMany('App\questions','quiz_id','id');
    }

    public function Author()
    {
        return $this->hasOne('App\User','id','author');
    }

    public function Category()
    {
        return $this->hasOne('App\categories','id','category_id');
    }

    public function attempts()
    {
        return $this->hasMany('App\quiz_attempts','quiz_id','id');
    }

}
