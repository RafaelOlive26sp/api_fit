<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleClassRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\ScheduleClassResource;
use App\Http\Resources\ScheduleShowClassResource;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScheduleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with([
            'user:id,name', // Carrega o usuário associado ao aluno
            'classes.classe.schedulesPatterns',
            'classes.classe.extraClasses',
            'payments' => function ($query) {
                $query->select('status', 'amount', 'due_date', 'students_id')
                    ->orderBy('due_date', 'desc')
                    ->limit(1);
            },

        ])->select('id', 'age', 'height', 'weight', 'gender', 'medical_condition', 'users_id')->get();

        return ScheduleClassResource::collection($students);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleClassRequest $request)
    {
        $validateData = $request->validated();
        // dd($validateData);
        StudentClass::create($validateData);

        return response()->json(['message' => 'Class Schedule with success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {

        // Verifica se o aluno existe (se necessário para validação extra)
        $student = Student::where('users_id',$request->user()->id )->first();
        $this->authorize('view', $student);
        $userStudent = Student::find($id);

        if(!$userStudent){
            abort(404, 'Nenhum aluno encontrado.');
        }

        $studentExist = StudentClass::where('students_id', $userStudent->id)
            ->with(
                'classe.schedulesPatterns',
                'classe.extraClasses'
            )->get();

        return ScheduleShowClassResource::collection($studentExist);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, string $id)
    {
        $validatedData = $request->validated();

        // Verifica se o aluno existe (se necessário para validação extra)
        Student::findOrFail($validatedData['students_id']);

        // Busca o registro de agendamento pelo ID
        $studentClass = StudentClass::findOrFail($id);


        // Atualiza os dados
        $studentClass->update($validatedData);

        return response()->json(['message' => 'Class Schedule updated with success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
