<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'total_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                'in:unpaid,paid,cancelled',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}
