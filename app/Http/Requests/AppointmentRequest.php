<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $student = auth()->user()->student; // Obtém o estudante associado ao usuário autenticado




        if ($student) {
            $payment = $student->payment()->latest()->first(); // Obtém o pagamento mais recente associado ao estudante

            $this->merge([
                'date' => date('Y-m-d ', strtotime($this->date)), // Converte a data
                'status' => 'scheduled',                             // Define o status padrão
                'students_id' => $student->id,                      // ID do estudante associado
                'payments_id' => $payment ? $payment->id : null,     // Verifica se há um pagamento e define o ID
            ]);
        } else {
            abort(403, 'O usuário autenticado não possui um estudante associado.'); // Tratamento de erro
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled',
            'students_id' => 'required|integer|exists:students,id',
            'class_schedules_id' => 'required|exists:class_schedules,id',
            'payments_id' => 'required|nullable|exists:payments,id',
        ];
    }
}
