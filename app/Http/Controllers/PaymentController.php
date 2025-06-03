<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentResquest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\Query\PaymentQueryService;
use App\Services\Query\StudentQueryService;
use App\Services\Query\UserQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\DTO\UpdatePaymentDTO;
use App\DTO\StorePaymentDTO;

use phpDocumentor\Reflection\Types\Boolean;
use function Laravel\Prompts\select;
use function PHPUnit\Framework\isEmpty;

class PaymentController extends Controller
{


    public function __construct(
        protected PaymentService $paymentService,
        protected PaymentQueryService $paymentQueryService,
        protected StudentQueryService $studentQueryService,
        protected UserQueryService $userQueryService,
    ){}

    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Payment::class);
        $payments = $this->paymentQueryService->getAllPayments();
        return PaymentResource::collection($payments);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentResquest $request, $id = null)
    {

        $user = $request->user();
        if ($id) {
            // Só admin pode passar o id de outro aluno
            $this->authorize('create', Payment::class);
            $student = $this->existsStudentWithId($id);

            // Verifica se o aluno existe com o id passado somente admin pode passar o ID
            if (!$student) {
                return response()->json(['message' => 'Usuário não concluiu o cadastro de aluno'], 404);
            }
             
            $this->validateDataAndCreatePayment($request, $student->id);
            return response()->json(['message' => 'Pagamento criado com sucesso'], 201);
        }
        // se o id não for passado, verifica se o usuario logado é um aluno, se sim,
        // Para aluno logado
        $student = $this->existsStudentWithId($user->id);
        if (!$student) {
            return response()->json(['message' => 'Usuário não concluiu o cadastro de aluno'], 404);
        }

        $this->validateDataAndCreatePayment($request, $student->id);
        return response()->json(['message' => 'Pagamento criado com sucesso'], 201);

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $userId = $request->user()->id;
        $student = $this->existsStudentWithId($userId);
        if (!$student) {
            return response()->json(['message' => 'O usuario nao concluiu o cadastro de aluno'], 404);
        }
        $this->authorize('view', $student);
        // retorna os pagamentos com base no id do usuario
        $paymentUserId = $this->getDataPaymentsWithUserId($student->id);
        if ($paymentUserId->isEmpty()) { //O isEmpty() e em caso de get()na consulta, aonde retorna um collection --
            // e em caso de retorno unico como first() o correto usar is_null($..)
            return response()->json(['message' => 'pagamento nao encontrado, efetue o pagamento para prosseguir'], 404);
        }
        $recentPayment = $this->getDataPaymentsWithUserId($student->id);
        $result = $this->verifiedIfPaymentIsEmpty($recentPayment);
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return  PaymentResource::collection($result);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, string $id)
    {
        try
        {
            $payment = $this->findDataPaymentWithUserId($id)->first();

            if(!$payment){
                return response()->json(['message'=>'O pagamento nao existe '], 404);
            }
            $this->authorize('update', $payment);

            $Dto = UpdatePaymentDTO::fromRequest($request->validated());
            $this->paymentService->update($Dto, $id);
            return response()->json(['message' => 'Pagamento atualizado com sucesso', 'status' => 200]);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar o pagamento: ' . $e->getMessage()], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = $this->findUserWithId($id);
        $this->authorize('delete', Payment::class);
        $payment = $this->findPaymentWithId($id);
        if ($this->deletePayment($payment)) {
            return response()->json(['message'=>'Pagamento Deletado com sucesso.']);
        };
        return response()->json(['message'=>'Erro ao deletar o pagamento'],500);
    }   

    private function deletePayment($data){
        return $data->delete();
        
    }
    private function findPaymentWithId($id)
    {
        // dd($id);
        $payment = $this->paymentQueryService->findDataPaymentUserId($id);
        if(!$payment){
            throw new ModelNotFoundException('Pagamento nao encontrado');
        }
        return $payment;
    }
    private function findUserWithId($id)
    {
        // Busca o usuário com base no ID
        $user = $this->userQueryService->getUserById($id);
        if (!$user) {
            throw new ModelNotFoundException('Usuário não encontrado');
        }
        return $user;
    }
    private function existsStudentWithId($id)
    {
        
        $existingStudent = $this->studentQueryService->getStudentByUserId($id);
        
        return $existingStudent;
    }

    private function validateDataAndCreatePayment(PaymentResquest $request, $userId)
    {
        //verifica se o pagamento foi efetuado
        $paymentDTO = StorePaymentDTO::fromRequest($request->validated());
        $this->paymentService->store($paymentDTO);
        
    }


     private function getDataPaymentsWithUserId($userId)
    {
        // Busca os pagamentos com base no ID do usuário retorna uma coleção de pagamentos
        return $this->paymentQueryService->getPaymentByUserId($userId);
    }
    private  function findDataPaymentWithUserId($id)
    {
        // Busca os pagamentos com base no ID do usuário retorna somente um pagamento
        return $this->paymentQueryService->findDataPaymentUserId($id);
    }

    private function verifiedIfPaymentIsEmpty($recentPayment)
    {
        if ($recentPayment->isEmpty() || $recentPayment->contains('status', 'overdue'))  // Verifica se o pagamento está vazio ou se contém status 'overdue'
        {
            //Se o pagamento estiver Vencido (overdue) ou vazio, retorna uma mensagem de erro
            $verifiedPayment = $this->paymentQueryService->getStatusPayment($recentPayment->first()->students_id);

            return response()->json([
                'message' => 'Existe pagamento atrasado',
                'paymentOverDue' => $verifiedPayment,
            ], 404);
        }

        return $recentPayment;
    }


}
