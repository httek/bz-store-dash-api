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
            'partner' => 'required',
            'name' => 'required',
            'logo' => 'required|url',
//            'photos' => 'array',
//            'photos.*' => 'url',
            'cash' => 'in:0,1',
            'cash_meta' => 'array',
            'address' => 'string',
//            'aptitude' => 'url',
            'deposit' => 'integer|min:0',
            'phone' => 'string|max:18',
            'deduct' => 'numeric|min:0|max:1',
            'sequence' => 'integer|min:0',
            'owner_id' => 'integer',
//            'delivery_template_id' => 'integer',
            'status' => 'in:0,1,2',
            'expired_at' => 'date_format:Y-m-d H:i:s'
        ];
    }
}
