<?php

namespace App\Http\Requests\Payment;

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
            //
        ];
    }
}
