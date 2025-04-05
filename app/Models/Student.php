<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'age','height','weight','gender','smoker','medical_condition','previous_experience','currently_praticing','users_id','id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
    public function classes()
    {
        return $this->hasMany(StudentClass::class,'students_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class,'students_id');
    }

}
