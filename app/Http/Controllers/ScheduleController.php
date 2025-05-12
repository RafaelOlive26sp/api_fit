<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleClassRequest;
use App\Http\Requests\UpdateScheduleRequest;

use App\Http\Resources\ScheduleClassResource;
use App\Http\Resources\ScheduleShowClassResource;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PhpParser\Builder;

class ScheduleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Precisa Adicionar a verificação de se o usuario é aluno ou professor
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
//
        // Verifica se o aluno existe (se necessário para validação extra)
        try {
            $student = Student::where('users_id', $request->user()->id)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Olá! Parece que você ainda não completou seu cadastro de aluno. Por favor, finalize seu perfil antes de continuar.');
        }

        $this->authorize('view', $student);

        // verifica se o aluno existe na tabela de aulas agendadas, capturando somente o Id através do Request
        $studentExist = StudentClass::where('students_id', $student->id)
            ->with(
                'classe.schedulesPatterns',
                'classe.extraClasses'
            )->get();

            if ($studentExist->isEmpty()) {
                abort(404, 'Não ha nenhum agendamento, Entre em contato com seu Professor.');
            }
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
