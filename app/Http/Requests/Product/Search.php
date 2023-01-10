<?php

namespace App\Http\Requests\Product;

use Anik\Form\FormRequest;

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
            'name' => 'string|max:40',
            'status' => 'in:-1,0,1,2'
        ];
    }

    /**
     * @param array $extra
     * @return array
     */
    public function filter(array $extra = [])
    {
        $where = [];
        if (($status = $this->input('status', -1)) >= 0) {
            $where['status'] = $status;
        }

        if ($name = $this->input('name')) {
            $where[] = ['name', 'LIKE', "%{$name}%"];
        }

        if (($category = $this->input('category_id', -1)) >= 0) {
            $where['category_id'] = $category;
        }

        return array_merge($where, $extra);
    }
}
