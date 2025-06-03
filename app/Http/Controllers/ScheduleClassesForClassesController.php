<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleClassesForClassesRequest;
//use App\Models\Appointment;
use App\Models\ClassSchedulesPattern;
use App\Services\ScheduleClassesFClassesService;
use App\Models\User;
use Illuminate\Http\Request;
use App\DTO\ScheduleClassesFClassesDTO\StoreScheduleClassesDTO;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScheduleClassesForClassesController extends Controller
{
    public function __construct(
        protected ScheduleClassesFClassesService $scheduleClassesFClassesService,
    ){}

    use AuthorizesRequests;
    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleClassesForClassesRequest $request)
    {
        $this->authorize('create', User::class);
        $this->validateAndCreateSchedule($request->validated());
        return response()->json(['message' => 'aula criada com sucesso!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $this->authorize('delete', User::class);
        return 'estamos em manutenção';
    }

    private function validateAndCreateSchedule($request)
    {
        $DTO = StoreScheduleClassesDTO::fromRequest($request);
        $this->scheduleClassesFClassesService->store($DTO);
    }


}
