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
        return
        [
            'date' => $this->date,
            'status' => $this->status,
                'students_id' => $this->students_id ?[
                    'age' => $this->student->age,
                    'height' => $this->student->height,
                    'weight' => $this->student->height,
                    'gender' => $this->student->gender,
                    'medical_condition' => $this->student->medical_condition,
                    'previous_experience' => $this->student->previous_experience,
                    'currently_praticing' => $this->student->currently_praticing,
                ]:null,
                'class_schedule_id' => $this->class_schedule ?[
                    'day_of_week' => $this->class_schedule->day_of_week,
                    'start_time' => $this->class_schedule->start_time,
                    'end_time' => $this->class_schedule->end_time,
                    'classes_id' => $this->class_schedule->classe ? [
                        'name' => $this->class_schedule->classe->name,
                        'schedule' => $this->class_schedule->classe->schedule,
                        'level' => $this->class_schedule->classe->level,
                    ]:null,
                ]:null,
                'payments_id' => $this->payment ?[
                    'amount' => $this->payment->amount,
                    'status' => $this->payment->status,
                    'due_date' => $this->payment->due_date,
                ]:null
        ];
    }
}
