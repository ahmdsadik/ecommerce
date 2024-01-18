<?php

namespace App\Http\Requests\Dashboard\Tag;

use App\Enums\TagStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            app()->getLocale() => ['required', 'array'],
            ...$this->translatedAttributesValidationRules(),
            'slug' => ['required', 'string', 'unique:tags,slug,' . $this->tag->id],
            'status' => [Rule::in(TagStatus::cases())]
        ];
    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $rules[$key . '.name'] = ['sometimes', 'required', 'string', Rule::unique('tag_translations', 'name')->ignore($this->tag->id, 'tag_id')];
        }
        return $rules;
    }

    protected function translatedAttributes(): array
    {
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key . '.name'] = __('dashboard/tag/create.name', ['lang' => __('lang_key.with_' . $key)]);
        }
        return $attributes;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        try {
            $this->merge([
                'status' => $this->has('status') ? TagStatus::ACTIVE->value : TagStatus::INACTIVE->value,
//                'slug' => Str::slug($this->input('slug')),
                'slug' => str_replace([' '], '-', $this->input(['slug']))
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
            ...$this->translatedAttributes(),
            'status' => __('dashboard/tag/edit.status'),
            'slug' => __('dashboard/tag/edit.slug')
        ];
    }

    /**
     * Get Messages for each error
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            app()->getLocale() . '.required' => __('dashboard/tag/validation.at_least', ['lang' => __('lang_key.with_' . app()->getLocale())]),
        ];
    }
}
