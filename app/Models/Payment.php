<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = ['amount','status','due_date','students_id','payments_id'];

    public function student()
    {
        return $this->hasOne(Student::class,'id','students_id');
    }
    public function appointment()
    {
        return $this->hasMany(Appointment::class,'payments_id');
    }
}
