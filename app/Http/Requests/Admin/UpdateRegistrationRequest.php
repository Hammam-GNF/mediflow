<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => [
                'required',
                'exists:patients,id',
            ],

            'doctor_id' => [
                'required',
                'exists:doctors,id',
            ],

            'complaint' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:registered,queued,examined,completed,cancelled',
            ],
        ];
    }
}
