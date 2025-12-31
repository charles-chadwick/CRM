<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        $user = $this->route('user');
        $is_update = $user !== null;

        return [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $is_update ? 'unique:users,email,'.$user->id : 'unique:users'
            ],
            'password' => [
                $is_update ? 'nullable' : 'required',
                'confirmed',
                Password::defaults()
            ],
            'role' => [
                'required',
                'string',
                'in:'.implode(',', array_map(fn($role) => $role->value, UserRole::cases()))
            ],
        ];
    }
}
