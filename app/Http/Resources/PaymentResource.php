<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load('student.user');

        return
        [
            'amount' =>$this->amount,
            'status' =>$this->status,
            'due_date' =>$this->due_date,
                'students_id' => $this->students_id && $this->student ?[
                    'users_id' => $this->student->users_id?[
                        'name' => $this->student->user->name,
                        'email' => $this->student->user->email,
                    ]:null
                ]:null
        ];
    }
}
