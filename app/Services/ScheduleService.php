<?php

namespace App\Services;


use App\DTO\ScheduleControllersDTO\StoreScheduleControllerDTO;
use App\Models\StudentClass;


class ScheduleService
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleControllerDTO $storeScheduleControllerDTO): void
    {
        // o usuario pode criar diversas turmas
        StudentClass::create($storeScheduleControllerDTO->toArray());
    }
}
