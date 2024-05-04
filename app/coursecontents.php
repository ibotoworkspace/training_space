<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coursecontents extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'id', 'course_id');
    }
}
