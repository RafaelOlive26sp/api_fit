<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentResquest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentResquest $request)
    {


        $this->authorize('create',  Student::class);
        $validateData = $request->validated();

        return Payment::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $student = Student::where('users_id', $id)->first();

        if(!$student){
           return response()->json(['message'=>'aluno nao encontrado'], 404);
        }



        $this->authorize('view', $student);

        if (!$student) {
            return response()->json(['message'=>'pagamento nao encontrado']);
        }
        $paymentUserId = Payment::where('students_id', $student->id)->get();

        if(!$paymentUserId){
            return response()->json(['message'=>'pagamento nao encontrado'],404);
        }

        return  PaymentResource::collection($paymentUserId);
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
