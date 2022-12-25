<?php

namespace App\Http\Requests\Delivery;

use Anik\Form\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|min:2',
            'type' => 'in:0,1,2',
            'tips' => 'string',
            'cost' => 'numeric',
            'status' => 'in:0,1',
            'sequence' => 'integer'
        ];
    }
}
