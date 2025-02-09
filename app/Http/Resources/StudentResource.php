<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'age'=>$this->age,
            'height'=>$this->height,
            'weight'=>$this->weight,
            'gender'=>$this->gender,
            'medical_condition'=>$this->medical_condition,
        ];
    }
}
