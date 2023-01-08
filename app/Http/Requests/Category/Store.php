<?php

namespace App\Http\Requests\Category;

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
            'name' => ['required', 'string', 'min:2'],
            'cover' => ['url'],
            'type' => ['nullable', 'in:1,2,3'],
            'sequence' => ['nullable', 'numeric', 'min:0'],
            'status' => ['in:0,1'],
            'parent_id' => ['nullable', 'numeric', 'min:0']
        ];
    }
}
