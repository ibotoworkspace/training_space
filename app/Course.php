<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'thumbnail', 'user_id', 'authorname', 'description'
    ];

    protected $table ='courses';

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_course', 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany('App\Enrollments');
    }

    public function userCourse()
    {
        return $this->hasMany('App\UserCourse');
    }

    public function contents()
    {
        return $this->hasMany('App\coursecontents', 'course_id', 'id');
    }

    public function quizes()
    {
        return $this->hasMany('App\quizes', 'course_id', 'id');
    }

    public function Author()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    
}
