<?php

namespace App\Http\Requests\Delivery;

use Anik\Form\FormRequest;

class SearchRequest extends FormRequest
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
            'type' => 'in:-1,0,1,2',
            'name' => 'string'
        ];
    }
}
