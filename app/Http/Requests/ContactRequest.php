<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'on_type' => [
                'required',
                'string'
            ],
            'on_id' => [
                'required',
                'integer',
                'min:1',
            ],
            'type' => [
                'required',
                'string'
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
