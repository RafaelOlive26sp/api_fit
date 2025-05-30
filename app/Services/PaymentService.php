<?php

namespace App\Services;

use App\DTO\UpdatePaymentDTO;
use App\DTO\StorePaymentDTO;
use App\Models\Payment;
use App\Services\Query\PaymentQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PaymentService
{
    public function __construct(
        protected PaymentQueryService $paymentQueryService
    ){}

    // Método para atualizar um pagamento
    public function update(UpdatePaymentDTO $updatePaymentDTO, string $id): void
    {
        $payment = $this->paymentQueryService->findDataPaymentUserId($id);

        if(!$payment){
            throw new ModelNotFoundException("Pagamento não encontrado.");
        }
        $payment->update($updatePaymentDTO->toArray());
    }
    // Método para armazenar um novo pagamento
    public function store(StorePaymentDTO $storePaymentDTO): void
    {   
        // Verifica se já existe um pagamento para o aluno
        $payment = $this->paymentQueryService->findDataPaymentUserId($storePaymentDTO->students_id);
        if ($payment) {
            throw new \Exception("Pagamento já existe para este aluno.");
        }
        Payment::create($storePaymentDTO->toArray());
    }


}
