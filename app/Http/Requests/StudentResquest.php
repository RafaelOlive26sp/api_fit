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
            'age' => ['required','integer','min:1','max:100'],
            'height' => ['required','numeric','min:1.30','max:2.0'],
            'weight' => ['required','numeric','min:30','max:200'],
            'gender' => ['required','string','in:female,male'],
            'smoker' => ['required','boolean'],
            'medical_condition' => ['required','string','max:255'],
            'previous_experience' => ['required','string','max:255'],
            'currently_praticing' => ['required','boolean'],
            'users_id' => 'required|exists:users,id',
        ];
    }
}
