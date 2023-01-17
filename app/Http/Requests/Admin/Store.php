<?php

namespace App\Http\Requests\Admin;

use Anik\Form\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:80',
            'mobile' => 'required|string|min:11|max:11',
            'password' => 'required|string|min:6|max:80',
            'status' => 'in:0,1',
            'avatar' => 'nullable|url',
            'role_id' => 'nullable|integer',
            'type' => 'in:1,2'
        ];
    }
}
