<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'date', 'status', 'students_id', 'class_schedules_id','payments_id'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class,'students_id');
    }
    public function class_schedule()
    {
        return $this->belongsTo(ClassSchedule::class,'class_schedules_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payments_id');
    }
}
