<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'on'          => ['required'],
            'on_id'       => [
                'required',
                'integer'
            ],
            'type'        => ['required'],
            'phone'       => ['nullable'],
            'fax'         => ['nullable'],
            'email'       => [
                'nullable',
                'email',
                'max:254'
            ],
            'address_1'   => ['nullable'],
            'address_2'   => ['nullable'],
            'city'        => ['nullable'],
            'state'       => ['nullable'],
            'postal_code' => ['nullable'],
            'country'     => ['nullable'],
            'notes'       => ['nullable'],
            
        ];
    }

    public function authorize() : bool
    {
        return true;
    }
}
