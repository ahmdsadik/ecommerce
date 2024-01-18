<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique(Admin::class)->ignore($this->user()->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(Admin::class)->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:15', Rule::unique(Admin::class)->ignore($this->user()->id)],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('dashboard/profile/edit.name'),
            'username' => __('dashboard/profile/edit.username'),
            'email' => __('dashboard/profile/edit.email'),
            'phone' => __('dashboard/profile/edit.phone'),
        ];
    }
}
