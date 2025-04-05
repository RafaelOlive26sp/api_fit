<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return
//        [
//            'date' => $this->date,
//            'status' => $this->status,
//                'students_id' => $this->students_id ?[
//                    'age' => $this->student->age,
//                    'height' => $this->student->height,
//                    'weight' => $this->student->height,
//                    'gender' => $this->student->gender,
//                    'medical_condition' => $this->student->medical_condition,
//                    'previous_experience' => $this->student->previous_experience,
//                    'currently_praticing' => $this->student->currently_praticing,
//                ]:null,
//                'class_schedule_id' => $this->class_schedule ?[
//                    'date' => $this->class_schedule->date,
//                    'day_of_week' => $this->class_schedule->day_of_week,
//                    'start_time' => $this->class_schedule->start_time,
//                    'end_time' => $this->class_schedule->end_time,
//                    'classes_id' => $this->class_schedule->classe ? [
//                        'name' => $this->class_schedule->classe->name,
//                        'schedule' => $this->class_schedule->classe->schedule,
//                        'level' => $this->class_schedule->classe->level,
//                    ]:null,
//                ]:null,
//                'payments_id' => $this->payment ?[
//                    'amount' => $this->payment->amount,
//                    'status' => $this->payment->status,
//                    'due_date' => $this->payment->due_date,
//                ]:null
//        ];
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'gender' => $this->gender,
            'medical_condition' => $this->medical_condition,
            'previous_experience' => $this->previous_experience,
            'currently_practicing' => $this->currently_practicing,
            'users_id' => $this->users_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email
            ],
            'student_class' => $this->classes->first() ? [
                'start_date' => $this->classes->first()->start_date,
                'end_date' => $this->classes->first()->end_date,
                'class' => [
                    'id' => $this->classes->first()->class->id,
                    'name' => $this->classes->first()->class->name,
                    'level' => $this->classes->first()->class->level,
                    'schedules' => $this->classes->first()->class->schedulesPatterns,
                    'extraClasses' => $this->classes->first()->class->extraClasses
                ]
            ] : null,
            'payment' => $this->payments
        ];
    }

}
