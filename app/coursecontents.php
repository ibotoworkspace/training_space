<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coursecontents extends Model
{
    protected $guarded = [];

    public function Course()
    {
        return $this->hasOne('App\Course', 'id', 'course_id');
    }

    public function Category()
    {
        return $this->hasOne('App\categories', 'id', 'category_id');
    }

    public function Author()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
