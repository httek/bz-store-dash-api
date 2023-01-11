<?php

namespace App\Http\Requests\Goods;

use Anik\Form\FormRequest;
use Illuminate\Database\Eloquent\Builder;

class Search extends FormRequest
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
            'store_id' => ['nullable', 'integer', 'min:0'],
            'brand_id' => ['nullable', 'integer', 'min:0'],
            'product_id' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['nullable', 'integer', 'min:0'],
            'delivery_id' => ['nullable', 'integer', 'min:0'],
            'name' => 'nullable|string|max:80',
            'status' => 'nullable|in:-1,0,1,2',
            'free_shipping' => 'nullable|in:-1,0,1',
            'sale_price' => 'array|max:2|min:2',
            'sale_price.*' => 'numeric|min:0'
        ];
    }

    /**
     * @param array $extra
     * @return array
     */
    public function filter(array $extra = [])
    {
        return function (Builder $query) use ($extra)
        {
            $where = $this->only(['store_id', 'brand_id', 'product_id', 'category_id', 'delivery_id']);
            $query->where(array_filter($where));

            if ($name = $this->input('name')) {
                $query->where('name', 'LIKE', "%{$name}%");
            }

            if (($status = $this->input('status', -1)) >= 0) {
                $query->whereStatus($status);
            }

            if (($freeShipping = $this->input('free_shipping', -1)) >= 0) {
                $query->where('free_shipping', $freeShipping);
            }

            if ($price = $this->input('sale_price')) {
                $price = array_map(fn($p) => $p * 100, $price);
                if ($price[1] > 0) {
                    $query->whereBetween('sale_price', $price);
                }
            }

            $extra && $query->where($extra);
        };
    }
}
