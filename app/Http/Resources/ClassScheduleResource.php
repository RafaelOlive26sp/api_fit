<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassScheduleResource extends JsonResource
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
            'day_of_week'=> $this->day_of_week,
            'start_time'=> $this->start_time,
            'end_time'=> $this->end_time,
                'classes_id' => $this->classe->id ? [
                    'name' => $this->classe->name,
                    'max_students' => $this->classe->max_students,
                    'schedule' => $this->classe->schedule,
                    'level' => $this->classe->level
                ] : null
        ];
    }
}
