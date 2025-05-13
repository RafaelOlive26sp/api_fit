<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassSchedulesResquest;
use App\Http\Resources\ClassScheduleResource;
use App\Models\Classe;
use App\Models\ClassSchedule;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClassSheduleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $classes = Classe::with([
            'schedulesPatterns',
            'extraClasses.classe',
            'user'=> function ($query) {
                $query->select('id', 'name');
            },
        ])->select('id', 'name', 'max_students', 'level')->get();


        return ClassScheduleResource::collection($classes);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassSchedulesResquest $request)
    {
        $this->authorize('create', User::class);
        $validateData = $request->validated();

        return ClassSchedule::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Int $id)
    {
        $class = ClassSchedule::with('classe')->findOrFail($id);

        return new ClassScheduleResource($class);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
