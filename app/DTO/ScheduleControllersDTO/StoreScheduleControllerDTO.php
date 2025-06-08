<?php

namespace App\DTO\ScheduleControllersDTO;




class StoreScheduleControllerDTO
{
    public function __construct(
        public int $students_id,
        public int $classes_id,
        public string $start_date,
        public ?string $end_date = null,
    )
    {}
    public static function fromRequest(array $request): self
    {
        return new self(
            students_id: $request['students_id'],
            classes_id: $request['classes_id'],
            start_date: $request['start_date'],
            end_date: $request['end_date'] ?? null,
        );
    }
    public function toArray(): array
    {
        return [
            'students_id' => $this->students_id,
            'classes_id' => $this->classes_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}
