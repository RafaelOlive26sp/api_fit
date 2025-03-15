<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentResquest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::with(['user:id,name'])
                ->select('age','height','weight','gender','medical_condition','users_id')->get();



        return 'estamos na index de student';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentResquest $request)
    {
        $validateData = $request->validated();

        return Student::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $userId = $request->user()->id;
        $student = Student::where('users_id', $userId)->first();
        $this->authorize('view', $student);
        return new StudentResource($student);
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
