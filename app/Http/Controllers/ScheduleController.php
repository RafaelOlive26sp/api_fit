<?php

namespace App\Http\Controllers;

use App\DTO\ScheduleControllersDTO\StoreScheduleControllerDTO;
use App\Services\ScheduleService;
use App\Http\Requests\ScheduleClassRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Notifications\newNotificationStudent;

use App\Http\Resources\ScheduleClassResource;
use App\Http\Resources\ScheduleShowClassResource;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\NewMessageNotification;


class ScheduleController extends Controller
{

    public function __construct(
        protected ScheduleService $ScheduleService,
    ){}
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Precisa Adicionar a verificação de se o usuario é aluno ou professor

        $this->authorize('viewAny', Student::class);
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
    // Este Controller é responsável por agendar aulas para os alunos
    public function store(ScheduleClassRequest $request)
    {
        $this->validateAndCreateSchedule($request->validated());
        return response()->json(['message' => 'Class Schedule with success'], 200);
    }

    private function validateAndCreateSchedule($request)
    {
        // Este método é responsável por validar e criar o agendamento de aulas
        $DTO = StoreScheduleControllerDTO::fromRequest($request);
        $this->ScheduleService->store($DTO);
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
        // Busca o usuário relacionado (exemplo, ajuste para sua estrutura real)
        $user = $studentClass->student->user;

        // Notifica o usuário
        $user->notify(new newNotificationStudent([
            'status' => 'info',
            'body' => 'Seu processor mudou voçe de turma!'
        ]));

        // Busca o usuário relacionado (exemplo, ajuste para sua estrutura real)
        $user = $studentClass->student->user;

        // Notifica o usuário
        $user->notify(new NewMessageNotification([
            'status' => 'info',
            'body' => 'Seu processor mudou voçe de turma!'
        ]));


        return response()->json(['message' => 'Class Schedule updated with success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', User::class);
        // Verifica se o aluno existe (se necessário para validação extra)
    }
}
