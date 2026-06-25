<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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

            'app_name' => [
                'required',
                'string',
                'max:255',
            ],

            'app_description' => [
                'nullable',
                'string',
            ],

            'company_email' => [
                'required',
                'email',
                'max:255',
            ],

            'company_phone' => [
                'required',
                'string',
                'max:20',
            ],

            'company_address' => [
                'nullable',
                'string',
            ],

            'pagination_per_page' => [
                'required',
                'integer',
                'min:1',
            ],

            'registration_enabled' => [
                'nullable',
                'boolean',
            ],

            'satusehat_environment' => [
                'nullable',
                'in:sandbox,production',
            ],

            'satusehat_organization_id' => [
                'nullable',
                'string',
            ],

            'satusehat_client_key' => [
                'nullable',
                'string',
            ],

            'satusehat_client_secret' => [
                'nullable',
                'string',
            ],

        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'registration_enabled' =>
                $this->boolean('registration_enabled'),
        ]);
    }
}
