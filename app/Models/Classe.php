<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'name','max_students','schedule','level','class_id'
    ];
    protected $casts = [
        'schedule' => 'array'
    ];
    public function class_schedule()
    {
        return $this->hasMany(ClassSchedule::class,'classes_id','id');
    }
}
