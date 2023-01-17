<?php

namespace App\Http\Requests\Payment;

use Anik\Form\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return ($this->user()->type ?? -1) == 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'version' => 'in:0,1',
            'name' => 'required|string|max:80',
            'merchant_id' => 'required|string|max:80',
            'merchant_name' => 'required|string|max:80',
            'secret' => 'nullable|string|max:400',
            'serial' => 'required|string|max:80',
            'public_key' => 'required|string',
            'private_key' => 'required|string',
            'platform_public_key' => 'required|string',
            'platform_key_serial' => 'required|string',
            'expired_at' => 'nullable|date_format:Y-m-d H:i:s'
        ];
    }
}
