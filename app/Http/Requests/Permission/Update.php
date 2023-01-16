<?php

namespace App\Http\Requests\Permission;

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
            'title' => 'required|string|min:2',
            'icon' => 'nullable|string',
            'type' => 'in:0,1,2',
            'sequence' => 'nullable|integer|min:0',
            'slug' => 'required|string|min:1',
            'status' => 'in:0,1',
            'component' => 'string',
            'parent_id' => 'nullable|integer|min:0',
            'path' => 'nullable|string'
        ];
    }
}
