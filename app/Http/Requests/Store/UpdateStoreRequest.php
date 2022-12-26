<?php

namespace App\Http\Requests\Store;

use Anik\Form\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name' => 'required',
            'store_name' => 'required',
            'store_logo' => 'required|url',
            'photos' => 'array',
            'photos.*' => 'url',
            'cash_type' => 'in:0,1',
            'cash_meta' => 'array',
            'address' => 'string',
            'aptitude' => 'url',
            'deposit' => 'integer|min:0',
            'phone' => 'string|max:18',
            'deduct' => 'integer|min:0',
            'sequence' => 'integer|min:0',
            'owner_id' => 'integer',
            'delivery_template_id' => 'integer',
            'status' => 'in:0,1,2'
        ];
    }
}
