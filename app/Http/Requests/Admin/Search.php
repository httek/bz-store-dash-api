<?php

namespace App\Http\Requests\Admin;

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
            'type' => 'in:-1,0,1,2'
        ];
    }

    /**
     * @return array
     */
    public function filter()
    {
        $where = [];
        if (($type = $this->input('type', -1)) >= 0) {
            $where['type'] = $type;
        }

        return $where;
    }
}
