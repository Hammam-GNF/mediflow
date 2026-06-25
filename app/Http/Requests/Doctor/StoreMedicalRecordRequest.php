<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
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

            'chief_complaint' => [
                'required',
                'string',
            ],

            'height' => [
                'nullable',
                'numeric',
            ],

            'weight' => [
                'nullable',
                'numeric',
            ],

            'blood_pressure' => [
                'nullable',
                'string',
                'max:50',
            ],

            'heart_rate' => [
                'nullable',
                'integer',
            ],

            'body_temperature' => [
                'nullable',
                'numeric',
            ],

            'respiratory_rate' => [
                'nullable',
                'integer',
            ],

            'diagnosis' => [
                'required',
                'string',
            ],

            'examination_notes' => [
                'nullable',
                'string',
            ],

            'primary_icd10_id' => [
                'required',
                'exists:icd10_codes,id',
            ],

            'secondary_icd10_ids' => [
                'nullable',
                'array',
            ],

            'secondary_icd10_ids.*' => [
                'exists:icd10_codes,id',
            ],

            'medications' => [
                'nullable',
                'array',
            ],

            'medications.*.medication_id' => [
                'required',
                'exists:medications,id',
            ],

            'medications.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'medications.*.dosage' => [
                'required',
                'string',
            ],

            'medications.*.frequency' => [
                'required',
                'string',
            ],

            'medications.*.duration' => [
                'required',
                'string',
            ],

            'medications.*.notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}
