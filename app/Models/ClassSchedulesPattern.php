<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedulesPattern extends Model
{
    protected $fillable = [
        'classes_id', 'day_of_week', 'start_time', 'end_time'
    ];
    public function class()
    {
        return $this->belongsTo(Classe::class, 'classes_id', 'id');
    }
}
