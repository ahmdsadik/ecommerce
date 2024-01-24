<?php

namespace App\Http\Requests\Dashboard\Role;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->translatedAttributesValidationRules(),
            'permissions' => ['array'],
            'permissions.*' => ['required', 'exists:permissions,id']
        ];
    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            foreach (Role::translatedAttributes() as $attr) {
                $rules[$key . ".$attr"] = ['sometimes', 'required', 'string', Rule::unique('role_translations', 'display_name')->ignore($this->role->id, 'role_id')];
            }
        }
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return Role::attributesNames();
    }
}
