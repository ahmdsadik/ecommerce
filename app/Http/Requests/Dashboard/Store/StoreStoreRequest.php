<?php

namespace App\Http\Requests\Dashboard\Store;

use App\Enums\StoreStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreStoreRequest extends FormRequest
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
            'slug' => ['required', 'unique:stores,slug'],
//            'mobile' => ['required', 'unique:vendors'],
//            'address' => ['required'],
//            'email' => ['nullable', 'email', 'max:254'],
//            'category_id' => ['required', 'exists:categories,id'],
//            'status' => ['nullable', Rule::in(StoreStatus::cases())],
            'logo' => ['required', 'image'],
        ];
    }

    protected function prepareForValidation()
    {
        try {
            $locale = app()->getLocale();
            $this->merge([
                'slug' => Str::slug($this->$locale['name']),
            ]);
        } catch (\Exception $e) {

        }
    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            if (!empty($this->$key['name'])) {
                $rules[$key . '.name'] = [app()->getLocale() == $key ? 'required' : 'nullable', 'string', 'unique:store_translations,name'];
                $rules[$key . '.description'] = [app()->getLocale() == $key ? 'required' : 'nullable', 'string'];
            }
        }
        return $rules;
    }

    protected function translatedAttributes(): array
    {
        $attributes = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $attributes[$key . '.name'] = __('dashboard/store/create.name', ['lang' => __('lang_key.with_' . $key)]);
        }
        return $attributes;
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
//            'status' => __('dashboard/store/create.status'),
            'slug' => __('dashboard/store/create.slug'),
            'logo' => __('dashboard/store/create.logo'),
        ];
    }
}
