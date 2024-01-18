<?php

namespace App\Http\Requests\Dashboard\Category;

use App\Enums\CategoryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryUpdateRequest extends FormRequest
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
            'slug' => ['required', 'string', 'unique:categories,slug,' . $this->category->id],
            'logo' => ['image', 'nullable'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'status' => [Rule::in(CategoryStatus::cases())]
        ];
    }

    protected function translationValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            if (!empty($this->$key['name'])) {
                $rules[$key . '.name'] = ['required', 'string', Rule::unique('category_translations', 'name')->ignore($this->category->id, 'category_id')];
                $rules[$key . '.description'] = ['nullable', 'string'];
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
                'slug' => Str::slug($this->slug),
                'status' => $this->has('status') ? CategoryStatus::ACTIVE->value : CategoryStatus::INACTIVE->value
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
        return
            [
                ...$this->translationAttributes(),
                'parent_id' => __('dashboard/category/create.main_category'),
                'logo' => __('dashboard/category/create.logo'),
                'status' => __('dashboard/category/edit.status')
            ];
    }


}
