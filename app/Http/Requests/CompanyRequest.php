<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'type'          => ['required'],
            'name'          => ['required'],
            'notes'         => ['nullable']
        ];
    }

    public function authorize() : bool
    {
        return true;
    }
}
