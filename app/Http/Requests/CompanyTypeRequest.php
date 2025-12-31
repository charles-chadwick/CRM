<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyTypeRequest extends FormRequest
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
        $companyType = $this->route('company_type');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $companyType
                    ? Rule::unique('company_types', 'name')->ignore($companyType)
                    : 'unique:company_types,name'
            ],
        ];
    }
}
