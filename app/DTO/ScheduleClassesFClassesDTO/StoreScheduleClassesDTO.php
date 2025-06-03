<?php

namespace App\DTO\ScheduleClassesFClassesDTO;


class StoreScheduleClassesDTO
{
    public function __construct(
        public int $classes_id,
        public string $day_of_week,
        public string $start_time,
        public string $end_time,
    ) {}

    public static function fromRequest(array $request): self
    {

        return new self(
            classes_id: $request['classes_id'],
            day_of_week: $request['day_of_week'],
            start_time: $request['start_time'],
            end_time: $request['end_time'],
        );
    }

    public function toArray(): array
    {
        return [
            'classes_id' => $this->classes_id,
            'day_of_week' => $this->day_of_week,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
