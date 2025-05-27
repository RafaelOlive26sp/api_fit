<?php

namespace App\Services\Query;


use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;



class PaymentQueryService
{
    /**
     * Get all payments.
     *
     * @return Collection
     */
    public function getAllPayments(): Collection
    {
        return Payment::with([
            'student.user:id,name' // Carrega o usuário associado ao aluno
        ])->select('id', 'status', 'amount', 'due_date', 'students_id')->get();
    }
    /**
     * Get a payment by ID.
     *
     * @param int $id
     * @return Payment|null
     */
    public function getPaymentById(int $id): ?Payment
    {
//        dd($id);
        return Payment::with([
            'student.user:id,name' // Carrega o usuário associado ao aluno
        ])->findOrFail($id);
    }
    public function getPaymentByUserId(int $id){
        $a= Payment::where('students_id', $id)->orderBy('created_at','desc')->get();
        return $a;
    }
    public function getStatusPayment(int $id){
        return Payment::where('status', 'overdue')->where('students_id', $id)->get();
    }
    public function findDataPaymentUserId(int $id)
    {
        return Payment::where('students_id', $id)->first();
    }
}
