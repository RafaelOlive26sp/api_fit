<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassesAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    private const MIN_PASSWORD_LENGTH = 8;
    private const EMAIL_PATTERN = '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$^';


    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => $this->getEmailRules(),
            'password' => $this->getPasswordRules(),
        ];
    }

    private function getEmailRules(): string
    {
        return 'required|email|regex:' . self::EMAIL_PATTERN;
    }
    private function getPasswordRules(): string
    {
        return 'required|string|min:' . self::MIN_PASSWORD_LENGTH;
    }
}
