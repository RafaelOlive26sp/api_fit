<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentResquest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentWithUserResources;
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
        $this->authorize('viewAny', Student::class);
        $student = Student::with(['user:id,name'])
                ->select('age','height','weight','gender','medical_condition','users_id')->paginate(5);
        return StudentWithUserResources::collection($student);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentResquest $request, $id = null)
    {
        $user = $request->user();

        if($user->can('create', Student::class)&& $id){
            $userId = $id;
        }else{
            $userId = $user->id;
        }

        $validateData = $request->validated();
        $validateData['users_id'] = $userId;

        Student::create($validateData);

        return response()->json(['message' => 'Profile completed with success','status' => 201], 201);
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
