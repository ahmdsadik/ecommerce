<?php

namespace App\Http\Requests\Dashboard\Admin;

use App\Enums\AdminStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'username' => ['nullable', 'max:30', 'unique:admins,username'],
            'email' => ['required', 'email', 'string', 'max:254', 'unique:admins,email'],
            'phone' => ['nullable'],
            'password' => ['required', 'string','min:8', 'max:250', 'confirmed'],
            'role_id' => ['array', 'required'],
            'role_id.*' => ['required', 'exists:roles,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
