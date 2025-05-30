<?php
namespace App\DTO;

class StorePaymentDTO
{
    public function __construct(
        public float  $amount,
        public string $status,
        public string $due_date,
        public int    $students_id,
    ){}

    public static function fromRequest(array $request): self
    {
        // dd($request);
        return new self(
            amount: $request['amount'],
            status: $request['status'],
            due_date: $request['due_date'],
            students_id: $request['students_id'],
        );
        
    }

    public function toArray(): array
    {
        return  [
            'amount' => $this->amount,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'students_id' => $this->students_id,
        ];
    }
}