<?php

namespace App\Http\Requests\Dashboard\Admin;

use App\Enums\AdminStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'username' => ['nullable', 'max:30', 'unique:admins,username,' . $this->admin->id],
            'email' => ['required', 'email', 'string', 'max:254', 'unique:admins,email,' . $this->admin->id],
            'phone' => ['nullable', 'unique:admins,phone,' . $this->admin->id],
            'password' => ['nullable', 'string', 'min:8', 'max:250'],
            'status' => ['sometimes', Rule::in(AdminStatus::cases())],
            'role_id' => ['array', 'required'],
            'role_id.*' => ['required', 'exists:roles,id']
        ];
    }

    protected function prepareForValidation(): void
    {
        try {
            $this->merge([
                'status' => $this->has('status') ? AdminStatus::ACTIVE->value : AdminStatus::INACTIVE->value
            ]);
        } catch (\Exception $exception) {

        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
