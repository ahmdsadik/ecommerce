<?php

namespace App\Http\Requests\Front\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => ['required'],
            'content' => ['required'],
            'rate' => ['required', 'numeric', 'max:5', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
