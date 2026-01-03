<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleLeadProgressRequest extends FormRequest
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
            'sales_lead_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:sales_leads,id'
            ],
            'status'        => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'title'         => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'notes'         => [
                'nullable',
                'string'
            ],
            'contacted_at'  => [
                'sometimes',
                'required',
                'date'
            ],
        ];
    }
}
