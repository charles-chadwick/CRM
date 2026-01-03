<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'company_id' => [
                'nullable',
                'integer',
                'exists:companies,id'
            ],
            'type' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'status' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'notes' => [
                'nullable',
                'string'
            ],
            'contacted_at' => [
                'sometimes',
                'required',
                'date'
            ],
        ];
    }
}
