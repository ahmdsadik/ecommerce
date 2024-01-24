<?php

namespace App\Http\Requests\Dashboard\Role;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RoleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->translatedAttributesValidationRules(),
            'name' => ['required'],
            'permissions' => ['array'],
            'permissions.*' => ['required', 'exists:permissions,id']
        ];
    }

    protected function prepareForValidation(): void
    {
        try {
            $this->merge([
                'name' => Str::random(10)
            ]);
        } catch (\Exception $exception) {

        }

    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            foreach (Role::translatedAttributes() as $attr) {
                $rules[$key . ".$attr"] = ['sometimes', 'required', 'string', 'unique:role_translations,display_name'];
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
