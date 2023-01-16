<?php

namespace App\Http\Requests\Goods;

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
            'brand_id' => ['nullable', 'integer', 'min:0'],
            'product_id' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['nullable', 'integer', 'min:0'],
            'delivery_id' => ['nullable', 'integer', 'min:0'],
            'name' => 'nullable|string|max:80',
            'covers' => 'nullable|array',
            'covers.*' => 'url',
            'badge' => 'string|max:10',
            'slogan' => 'string|max:80',
            'tips' => 'string|max:80',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:10',
            'detail' => 'nullable|array',
            'detail.*' => 'url',
            'material' => 'string|max:120',
            'sale_price' => 'integer|min:0|max:99999',
            'origin_price' => 'integer|min:0|max:99999',
            'description' => 'string|max:80',
            'stock' => 'integer|min:0|max:9999999',
            'sold' => 'integer|min:0|max:9999999',
            'status' => 'integer|in:0,1,2',
            'free_shipping' => 'nullable|in:0,1',
            'sequence' => 'integer|min:0|max:99999999',
        ];
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        $validated = parent::validated();
        $validated['free_shipping'] = ($validated['delivery_id'] ?? 0) == 0;

        return array_filter($validated, fn($value) => $value != '');
    }
}
