<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassSchedulesResquest extends FormRequest
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
        if ($this->has('start_time') && !$this->has('end_time')) {

            $startTime = \Carbon\Carbon::createFromFormat('H:i', $this->input('start_time'));
            $endTime = $startTime->copy()->addHour()->format('H:i');
            $this->merge([
                'end_time' => $endTime,
            ]);
        }
        if ($this->has('date')){
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $this->input('date'));
            $dayOfWeek = $date->format('l');
            $this->merge([
                'day_of_week' => $dayOfWeek,
            ]);
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
            'day_of_week' => 'required|string|',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'classes_id' => 'required|integer|exists:classes,id',
        ];
    }
}
