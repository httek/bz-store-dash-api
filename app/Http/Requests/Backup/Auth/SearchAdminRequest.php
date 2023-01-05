<?php

namespace App\Http\Requests\Auth;

use Anik\Form\FormRequest;

class SearchAdminRequest extends FormRequest
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
            'name' => '',
            'type' => 'in:0,1',
            'status' => 'in:-1,0,1',
            'mobile' => 'string|max:11|min:11',
            'role_id' => 'integer'
        ];
    }

    /**
     * @return array
     */
    public function getSearches(): array
    {
        $input = $this->validated();
        $search = $this->only(['mobile', 'role_id', 'type']);
        if (!empty($input['name'])) {
            $search[] = ['name', 'like', "%{$input['name']}%"];
        }

        if (!empty($input['status']) && $input['status'] >= 0) {
            $search['status'] = $input['status'];
        }

        return array_filter($search, function ($value) {
            return !empty($value) || $value >= 0;
        });
    }
}
