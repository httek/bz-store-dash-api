<?php

namespace App\Http\Requests\Swiper;

use Anik\Form\FormRequest;

class Update extends FormRequest
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
            'position' => ['in:0,1'],
            'status' => ['in:0,1'],
            'style' => 'in:fraction,dots,dots-bar,controls',
            'visible_begin' => 'date_format:Y-m-d H:i:s',
            'visible_ending' => 'date_format:Y-m-d H:i:s',
            'items' => 'nullable|array',
            'items.*' => 'array',
            'items.*.image' => 'url',
        ];
    }
}
