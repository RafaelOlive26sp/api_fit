<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentResquest extends FormRequest
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

        $this->merge([
            'users_id' => auth()->id(),
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
            'age' => ['required','integer','min:1','max:100','regex:/^[0-9]+$/'],
            'height' => ['required','numeric','min:1.30','max:2.0','regex:/^\d+(\.\d{1,2})?$/'],
            'weight' => ['required','numeric','min:30','max:200','regex:/^\d+(\.\d{1,2})?$/'],
            'gender' => ['required','string','in:female,male','regex:/^[a-zA-Z]+$/'],
            'smoker' => ['required','boolean'],
            'medical_condition' => ['required','string','max:255','regex:/^[a-zA-Z0-9\s]+$/'],
            'previous_experience' => ['required','string','max:255','regex:/^[a-zA-Z0-9\s]+$/'],
            'currently_praticing' => ['required','boolean'],
            'users_id' => 'required|exists:users,id',
        ];
    }
}
