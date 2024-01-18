<?php

namespace App\Http\Requests\Front\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer','min:1'],
//            'options' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
