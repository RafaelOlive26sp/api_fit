<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {

        $validateData = $request->validated();

        return Appointment::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $userId = auth()->user()->id;
        // $studentUser = Student::where('users_id', $userId);

        // $this->authorize('view', $studentUser);
        // Falta configurar a Policy


         return new AppointmentResource(
            Appointment::where('id', $id)
            ->with(['class_schedule.classe', 'payment', 'student'])
            ->firstOr(fn() => abort(404, 'Nenhum agendamento encontrado.'))
         );

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
