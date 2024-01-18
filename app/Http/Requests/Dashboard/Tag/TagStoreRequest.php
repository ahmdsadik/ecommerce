<?php

namespace App\Http\Requests\Dashboard\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            app()->getLocale() => ['required', 'array'],
            ...$this->translatedAttributesValidationRules(),
            'slug' => ['required', 'string', 'unique:tags'],
        ];
    }

    protected function translatedAttributesValidationRules(): array
    {
        $rules = [];

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $key) {
            $rules[$key . '.name'] = ['sometimes', 'required', 'string', 'unique:tag_translations,name'];
        }
        return $rules;
    }



    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $value = app()->getLocale();
        try {
            $this->merge([
                'slug' => str_replace([' '], '-', $this->$value['name']),
//                'slug' => implode('-', explode(' ', $this->$value['name'])),
//                'slug' => Str::slug($this->$value['name']),
//                'slug' => Str::slug($this->{app()->getLocale()}['name']),
            ]);
        } catch (\TypeError $e) {
        } catch (\Exception $e) {
            throw ValidationException::withMessages(
                [
                    $value . '.name' => __('validation.required', ['attribute' => __('dashboard/tag/create.name', ['lang' => __('lang_key.with_' . $value)])])
                ]
            );
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return Tag::attributesNames();
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
