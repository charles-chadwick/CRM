<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'on_type'    => [
                'required',
                'string',
                'max:255'
            ],
            'on_id'      => [
                'required'
            ],
            'image_type' => [
                'required',
                'string',
                'in:avatars,logo'
            ],
            'image'      => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:2048'
                // 2MB max
            ],
        ];
    }
}
