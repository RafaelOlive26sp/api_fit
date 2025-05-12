<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
  protected $fillable = [
      'id','date','status','start_time','end_time','classes_id'
  ];
  public function classe()
  {
      return $this->belongsTo(Classe::class,'classes_id','id');
  }
  public function appointment()
  {
      return $this->hasMany(Appointment::class,'class_schedules_id');
  }
}
