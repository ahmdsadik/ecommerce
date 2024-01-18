<?php

namespace App\Http\Requests\Dashboard\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductUpdateRequest extends FormRequest
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
            'slug' => ['required', 'unique:products,slug,' . $this->product->id],
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
        $this->merge([
            'feature' => $this->has('feature') ? 1 : 0
        ]);
    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        try {
            foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
                if (!empty($this->$key['name']) || $key == app()->getLocale()) {
                    $rules[$key . '.name'] = [app()->getLocale() == $key ? 'required' : 'nullable', 'string', Rule::unique('product_translations', 'name')->ignore($this->product->id, 'product_id')];

                    $rules[$key . '.short_description'] = [app()->getLocale() == $key ? 'required' : 'nullable', 'string'];
                    $rules[$key . '.description'] = [app()->getLocale() == $key ? 'required' : 'nullable', 'string'];
                }
            }
        } catch (\Exception $e) {}

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
