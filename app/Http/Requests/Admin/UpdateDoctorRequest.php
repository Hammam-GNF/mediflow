<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
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
        $doctor = $this->route('doctor');

        return [
            'polyclinic_id' => [
                'required',
                'exists:polyclinics,id',
            ],

            'doctor_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('doctors', 'doctor_code')
                    ->ignore($doctor),
            ],

            'nik' => [
                'nullable',
                'digits:16',
            ],

            'sip_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
