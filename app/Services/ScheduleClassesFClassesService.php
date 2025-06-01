<?php


namespace App\Services;


use App\DTO\ScheduleClassesFClassesDTO\StoreScheduleClassesDTO;
use App\Services\Query\ScheduleClassesQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\ClassSchedulesPattern;



class ScheduleClassesFClassesService
{
    public function __construct(
            protected ScheduleClassesQueryService $scheduleClassesFClassesService,
    ){}

    public function store(StoreScheduleClassesDTO $request): void
    {
//        dd($request->classes_id);
        $ifExists = $this->scheduleClassesFClassesService->ifExistsClassSchedulePatternById($request->classes_id);
        if (!$ifExists) {
            throw new ModelNotFoundException("A Classe nao existe.");
        }
        ClassSchedulesPattern::create($request->toArray());


    }

//    public function update($request, string $id): void
//    {
//        $updateScheduleClassesDTO = UpdateScheduleClassesDTO::fromRequest($request->all());
//        $this->scheduleClassesFClassesService->update($updateScheduleClassesDTO, $id);
//    }
}
