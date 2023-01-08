<?php

namespace App\Http\Requests\Brand;

use Anik\Form\FormRequest;

class Update extends FormRequest
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
            'site' => ['nullable', 'url'],
            'sequence' => ['nullable', 'numeric', 'min:0'],
            'status' => ['in:0,1'],
            'category_id' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:300']
        ];
    }
}
