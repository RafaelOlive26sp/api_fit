<?php

namespace App\DTO;

class UpdatePaymentDTO
{
    public function __construct(
        public float  $amount,
        public string $status,
        public string $due_date,
    ){}

    public static function fromRequest(array $request): self
    {
        return new self(
            amount: $request['amount'],
            status: $request['status'],
            due_date: $request['due_date']
        );
    }
    public function toArray(): array
    {
        return  [
            'amount' => $this->amount,
            'status' => $this->status,
            'due_date' => $this->due_date,
        ];
    }
}
