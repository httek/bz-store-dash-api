<?php

namespace App\Http\Requests\Category;

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
        return [];
    }

    /**
     * @param array $extra
     * @return array
     */
    public function filter(array $extra = [])
    {
        $where = [];
        if ($name = $this->input('name')) {
            $where[] = ['name', 'like', "%{$name}%"];
        }

        if ($status = $this->input('status')) {
            $where['status'] = $status;
        }

        return array_merge($where, $extra);
    }
}
