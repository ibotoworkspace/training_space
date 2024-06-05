<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $guarded = [];

    public function Payee()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function Course()
    {
        return $this->hasOne('App\Course', 'id', 'course_id');
    }



}
