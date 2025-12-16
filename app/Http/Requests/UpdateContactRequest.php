<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'on_type' => [
                'required',
                'string',
                Rule::in(['Company', 'Customer']),
            ],
            'on_id' => [
                'required',
                'integer',
                'min:1',
            ],
            'type' => [
                'required',
                'string',
                Rule::in(['Personal', 'Cell', 'Office']),
            ],
            'is_primary' => [
                'nullable',
                'boolean',
            ],
            'address_1' => [
                'nullable',
                'string',
                'max:255',
            ],
            'address_2' => [
                'nullable',
                'string',
                'max:255',
            ],
            'city' => [
                'nullable',
                'string',
                'max:255',
            ],
            'state' => [
                'nullable',
                'string',
                'max:255',
            ],
            'postal_code' => [
                'nullable',
                'string',
                'max:50',
            ],
            'country' => [
                'nullable',
                'string',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}
