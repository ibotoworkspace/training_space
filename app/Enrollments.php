<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollments extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'status'
    ];

    protected $table = "enrollments";

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function payment()
    {
        return $this->hasOne('App\payments','user_id','user_id');
    }
}
