<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class PaymentResquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation()
    {
//            dd(request()->all());
        $userId = $this->input('userId');
        $student =  $userId ? Student::where('users_id', $userId )->first() : auth()->user()->student;
//            dd($student);
        if (!$student) {
            abort(422, 'Nenhum estudante associado ao usuário autenticado.');
        }

        $this->merge([
            'students_id' => $student->id,
            'status' => 'pending',
            'due_date' => now()->addMonth()->toDateString(),

        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'students_id' => ['required', 'exists:students,id'],
        ];
    }
}
