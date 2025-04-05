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
//
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'max_students' => $this->max_students,
            'level' => $this->level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'schedules_patterns' => $this->schedulesPatterns,
            'extra_classes' => $this->extraClasses,
        ];
    }
}
