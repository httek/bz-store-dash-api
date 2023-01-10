<?php

namespace App\Http\Requests\Product;

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
            'name'              => ['string', 'max:40', 'min:1'],
            'status'            => 'nullable|in:0,1,2',
            'covers'            => ['nullable', 'array'],
            'covers.*'          => 'url',
            'sequence'          => ['nullable', 'integer'],
            'category_id'       => ['nullable', 'integer', 'min:0'],
            'description'       => ['string', 'max:300']
        ];
    }
}
