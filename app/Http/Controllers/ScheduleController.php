<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleClassRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\ScheduleClassResource;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
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
    public function show(string $id)
    {
        //
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
