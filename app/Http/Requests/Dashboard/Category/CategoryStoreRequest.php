<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use PhpParser\Node\Expr\Array_;

class CategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            app()->getLocale() => ['required', 'array'],
            ...$this->translationValidationRules(),
            'slug' => ['required', 'string', 'unique:categories'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'logo' => ['image', 'nullable']
        ];
    }

    protected function translationValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            if (!empty($this->$key['name'])) {
                $rules[$key . '.name'] = ['required', 'string', 'unique:category_translations,name'];
                $rules[$key . '.description'] = ['nullable', 'string', 'unique:category_translations,description'];
            }
        }
        return $rules;
    }

    protected function translationAttributes(): array
    {
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key . '.name'] = __('dashboard/category/create.name', ['lang' => __('lang_key.with_' . $key)]);
            $attributes[$key . '.description'] = __('dashboard/category/create.description', ['lang' => __('lang_key.with_' . $key)]);
        }
        return $attributes;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $value = app()->getLocale();
        try {
            $this->merge([
                'slug' => Str::slug($this->$value['name'])
            ]);
        } catch (\Exception $e) {
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {

        return [
            ... $this->translationAttributes(),
            'parent_id' => __('dashboard/category/create.category'),
            'logo' => __('dashboard/category/create.logo'),
            'status' => __('dashboard/category/edit.status')
        ];
    }
}
