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
            'app_name'
                => ['required', 'string', 'max:255'],

            'app_email'
                => ['required', 'email', 'max:255'],

            'app_phone'
                => ['required', 'string', 'max:20'],
                
            'satusehat_environment'
                => ['nullable'],

            'satusehat_organization_id'
                => ['nullable'],

            'satusehat_client_key'
                => ['nullable'],

            'satusehat_client_secret'
                => ['nullable'],
        ];
    }
}
