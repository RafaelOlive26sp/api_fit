<?php

namespace App\Services;

use App\DTO\UpdatePaymentDTO;
use App\Services\Query\PaymentQueryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PaymentService
{
    public function __construct(
        protected PaymentQueryService $paymentQueryService
    ){}


    public function update(UpdatePaymentDTO $updatePaymentDTO, string $id): void
    {

        $payment = $this->paymentQueryService->findDataPaymentUserId($id);

        if(!$payment){
            throw new ModelNotFoundException("Pagamento não encontrado.");
        }
        $payment->update($updatePaymentDTO->toArray());
    }


}
