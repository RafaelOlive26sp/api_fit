<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserResquest extends FormRequest
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
            'role' => 'student',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ?? null;
        return [

                'name' => ['required','string','max:255','regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
                'email' => 'required|email|string|unique:users,email,'. $userId,
                'password' => 'required|string|min:6',
                'role' => 'required|string|in:student',

        ];
    }
}
