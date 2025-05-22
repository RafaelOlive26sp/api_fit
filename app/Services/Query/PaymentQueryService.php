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
        return Payment::with([
            'student.user:id,name' // Carrega o usuário associado ao aluno
        ])->findOrFail($id);
    }
    /**
     * Store payments for a specific student.
     *
     * @param int $studentId
     * @return Collection
     */
    public function storePaymentsForStudent(int $studentId): Collection
    {
        return Student::where('users_id', $studentId)->first() || null;
    }
}    