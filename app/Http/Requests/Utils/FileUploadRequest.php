<?php

namespace App\Http\Requests\Utils;

use Anik\Form\FormRequest;

class FileUploadRequest extends FormRequest
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
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf'
        ];
    }
}
