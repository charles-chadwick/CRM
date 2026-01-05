<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'on_type' => ['required', 'string', 'max:255'],
            'on_id'   => ['required'],
            'documents' => ['required', 'array'],
            'documents.*' => ['file', 'max:10240'], // 10MB limit per file
            'collection' => ['nullable', 'string'],
        ];
    }
}
