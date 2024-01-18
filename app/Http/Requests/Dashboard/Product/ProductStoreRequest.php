<?php

namespace App\Http\Requests\Dashboard\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductStoreRequest extends FormRequest
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
            'slug' => ['unique:products,slug'],
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'tag_id' => ['nullable', 'array'],
            'tag_id.*' => ['exists:tags,id'],
            'price' => ['required', 'numeric'],
            'compare_price' => ['nullable', 'numeric','gt:price'],
            'logo' => ['nullable', 'image'],
            'status' => ['required', Rule::in(ProductStatus::cases())],
            'feature' => ['in:0,1']
        ];
    }

    protected function prepareForValidation(): void
    {
        try {
            $locale = app()->getLocale();
            $this->merge([
                'slug' => Str::slug($this->$locale['name']),
                'feature' => $this->has('status') ? 1 : 0
            ]);
        } catch (\Exception $e) {
            throw ValidationException::withMessages(
                [
                    $locale . '.name' => __('validation.required', ['attribute' => __('dashboard/tag/create.name', ['lang' => __('lang_key.with_' . $locale)])])
                ]
            );
        }
    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            if (!empty($this->$key['name']) || $key == app()->getLocale()) {
                $rules[$key . '.name'] = ['required', 'string', 'unique:product_translations,name'];
                $rules[$key . '.short_description'] = [ 'nullable', 'string'];
                $rules[$key . '.description'] = [ 'nullable', 'string'];
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
        return Product::attributesNames();
    }

}
