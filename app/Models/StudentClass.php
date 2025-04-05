<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'students_classes';
    protected $fillable =[
        'students_id','classes_id','start_date','end_date'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'students_id', 'id');
    }

    // Relacionamento com o modelo Class
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classes_id', 'id');
    }
}
