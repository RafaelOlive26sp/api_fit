<?php

namespace App\Http\Controllers;


use App\Http\Resources\ClassScheduleResource;
use App\Models\Classe;
use App\Models\ClassSchedule;
use App\Models\User;
use App\Services\Query\ClasseQueryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClassSheduleController extends Controller
{



//    public function __construct( protected ClasseQueryService $classeQueryService,
//                                protected ClassScheduleQueryService $classScheduleQueryService
//    )
//    {
//
//    }
    public function __construct(protected ClasseQueryService $classeQueryService)
    {}

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('viewAny', User::class);
        $classes = $this->classeQueryService->getAllClasses();

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
        // $class = ClassSchedule::with('classe')->findOrFail($id);
        $class = $this->classeQueryService->getClassScheduleById($id);

        return new ClassScheduleResource($class);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('viewAny', User::class);
        return "Em breve, estaremos com esta funcionalidade";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('viewAny', User::class);
        return "Em breve, estaremos com esta funcionalidade";
    }
}
