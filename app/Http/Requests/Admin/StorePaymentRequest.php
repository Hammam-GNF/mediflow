<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'payment_method' => [
                'required',
                Rule::in([
                    'cash',
                    'transfer',
                    'qris',
                ]),
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'payment_reference' => [
                Rule::requiredIf(fn () => in_array(
                    $this->payment_method,
                    ['transfer', 'qris']
                )),
                'nullable',
                'string',
                'max:100',
            ],

            'payment_proof' => [
                Rule::requiredIf(fn () => in_array(
                    $this->payment_method,
                    ['transfer', 'qris']
                )),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];

    }
}