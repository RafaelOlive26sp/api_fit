<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointment = Appointment::all();
        dd($appointment);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request, $id = null)
    {
        $user = $request->user();

        // Verifica se o usuário é um administrador
        if ($user->can('create', Appointment::class) && $id) {
           abort(403, 'Você não tem permissão para criar um agendamento.');
        }

        $student = Student::find($id);
        if(!$student){
            abort(404, 'Nenhum aluno encontrado.');
        }

        $validateData = $request->validated();
        $validateData['students_id'] = $student->id;
        $validateData['users_id'] = $user->id;

        // dd($validateData);


        return Appointment::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::id();

        $student = Student::where('users_id', $userId)->first();
       dd($student->id);

        if(!$student){
            abort(404, 'Nenhum aluno encontrado.');
        }
        $appointment = Appointment::where('students_id', $student->id)
            ->with(['class_schedule.classe', 'payment', 'student'])
            ->get();

        if ($appointment->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum agendamento encontrado para o estudante.'
            ], 404);
        }



        return AppointmentResource::collection($appointment);




//         return new AppointmentResource(
//            Appointment::where('id', $id)->where('students_id', $student->id)
//            ->with(['class_schedule.classe', 'payment', 'student'])
//            ->firstOr(fn() => abort(404, 'Nenhum agendamento encontrado.'))
//         );

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
