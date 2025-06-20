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
//        $student = Student::with(['user:id,name'])
//                ->select('age','height','weight','gender','medical_condition','users_id')->paginate(5);
        $students = Student::with([
                'user:id,name', // Carrega o usuário associado ao aluno
                'payments'=> function ($query) {
                    $query->select('status', 'amount', 'due_date', 'students_id')
                    ->orderBy('due_date','desc')
                    ->limit(1);
                }
        ])->select('id', 'age', 'height', 'weight', 'gender', 'medical_condition', 'users_id')->paginate(5);


//        dd($student);
        return StudentWithUserResources::collection($students);
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
        $ifUserExist = Student::where('users_id', $userId)->exists();
        if ($ifUserExist){
            return response()->json(['message' => 'Profile already exists','status' => 409], 409);
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
        $this->authorize('update', User::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', User::class);
    }
}
