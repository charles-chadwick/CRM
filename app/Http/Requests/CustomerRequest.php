<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'company_id' => [
                'nullable',
                'exists:companies'
            ],
            'title' => ['nullable'],
            'prefix' => ['nullable'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'suffix' => ['nullable'],
            'email' => [
                'required',
                'email',
                'max:254'
            ],
            'email_verified_at' => [
                'nullable',
                'date'
            ],
            'password' => ['required'],
            'remember_token' => ['nullable'],
            'created_by_id' => [
                'required',
                'integer'
            ],
            'updated_by_id' => [
                'nullable',
                'integer'
            ],
            'deleted_by_id' => [
                'nullable',
                'integer'
            ],

        ];
    }

    public function authorize() : bool
    {
        return true;
    }
}
