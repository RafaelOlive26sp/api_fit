<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentResquest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;
use function PHPUnit\Framework\isEmpty;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Payment::class);
        $payments = Payment::with([
            'student.user:id,name' // Carrega o usuário associado ao aluno
        ])->select('id', 'status', 'amount', 'due_date', 'students_id')->get();
        // dd($payments);
        return PaymentResource::collection($payments);

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
    public function store(PaymentResquest $request, $id = null)
    {

        $user = $request->user();


        if ($user->can('create', Payment::class) && $id) {
            $student = Student::where('users_id', $id)->first();
            if (!$student) {
                return response()->json(['message' => 'O usuário não concluiu o cadastro de aluno'], 404);
            }
            $userId = $student->id;
        } else {
            $student = Student::where('users_id', $user->id)->first();
            if (!$student) {
                return response()->json(['message' => 'O usuário não concluiu o cadastro de aluno'], 404);
            }
            $userId = $student->id;
        }


        $validateData = $request->validated();
        $validateData['students_id'] = $userId;

//        dd($validateData);

        return Payment::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $student = Student::where('users_id', $id)->first();

        if(!$student){
           return response()->json(['message'=>'O usuario nao concluiu o cadastro de aluno'], 404);
        }



        $this->authorize('view', $student);


        $paymentUserId = Payment::where('students_id', $student->id)->get();


        if ($paymentUserId->isEmpty()) {
            return response()->json(['message' => 'pagamento nao encontrado'], 404);
        }
        $recentPayment = Payment::where('students_id', $student->id)
            ->orderBy('created_at', 'desc') // Ordena por data de criação, da mais recente para a mais antiga
            ->first();

        if ($recentPayment && $recentPayment->status === 'overdue') {
            // Casos em que o pagamento mais recente está com status "overdue"
            $paymentOverDue = Payment::where('status', 'overdue')
                ->where('students_id', $student->id)
                ->get();

            $paymentOverDue = PaymentResource::collection($paymentOverDue);

            return response()->json([
                'message' => 'Existe pagamento atrasado',
                'paymentOverDue' => $paymentOverDue,
            ], 404);
        }




        return  PaymentResource::collection($paymentUserId);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, string $id)
    {


        $payment = Payment::where('students_id', $id)->first();

        if(!$payment){
            return response()->json(['message'=>'O pagamento nao existe '], 404);
        }


        $this->authorize('update', $payment);
        $data = $request->validated();
//            dd($data);
        $payment->update($data);

        return response()->json(['message' => 'Pagamento atualizado com sucesso', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
