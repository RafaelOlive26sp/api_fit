<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'name','max_students','level'
    ];
    protected $casts = [
        'schedule' => 'array'
    ];
    public function class_schedule()
    {
        return $this->hasMany(ClassSchedule::class,'classes_id','id');
    }

   // Relacionamento com StudentClass
   public function students()
   {
       return $this->hasMany(StudentClass::class, 'classes_id', 'id');
   }

   // Relacionamento com ClassSchedulesPatterns
   public function schedulesPatterns()
   {
       return $this->hasMany(ClassSchedulesPattern::class, 'classes_id', 'id');
   }

   // Relacionamento com ClassSchedules (aulas extras)
   public function extraClasses()
   {
       return $this->hasMany(ClassSchedule::class, 'classes_id', 'id');
   }

   public function students_class()
   {
       return $this->hasMany(StudentClass::class, 'classes_id', 'id');
   }
}
