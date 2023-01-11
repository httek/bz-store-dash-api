<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class Login extends FormRequest
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
            'mobile' => 'required|min:11|max:11',
            'password' => 'required|string|min:6|max:40'
        ];
    }

    /**
     * @return mixed
     */
    public function account()
    {
        return $this->input('mobile');
    }
}
