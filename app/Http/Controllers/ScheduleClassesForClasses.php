<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleClassesForClassesRequest;
use App\Models\Appointment;
use App\Models\ClassSchedulesPattern;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScheduleClassesForClasses extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

       return 'estamos em manutenção';
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleClassesForClassesRequest $request)
    {
        $this->authorize('create', User::class);
        $validateData = $request->validated();
        ClassSchedulesPattern::create($validateData);

        return response()->json(['message' => 'aula criada com sucesso!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('viewAny', User::class);
        return 'estamos em manutenção';
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this-> authorize('update', User::class);
        return 'estamos em manutenção';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $this->authorize('delete', User::class);
        return 'estamos em manutenção';
    }
}
