<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePolyclinicRequest extends FormRequest
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
        $polyclinic = $this->route('polyclinic');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('polyclinics')
                    ->ignore($polyclinic)
            ],
            'description' => ['nullable'],

            'satusehat_location_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'is_active' => ['required', 'boolean'],
        ];
    }
}
