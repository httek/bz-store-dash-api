<?php

namespace App\Http\Requests\Store;

use Anik\Form\FormRequest;
use Illuminate\Support\Facades\DB;

class Search extends FormRequest
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
            'partner' => 'string',
            'name' => 'string',
            'cash' => 'in:-1,0,1',
            'status' => 'in:-1,0,1,2',
            'owner_id' => 'numeric|integer|min:0',
            'created_at' => 'array|max:2|min:2'
        ];
    }

    /**
     * @return array
     */
    public function filter(): array
    {
        $search = [];
        $validated = $this->validated();
        if (!empty($validated['partner'])) {
            $search[] = ['partner', 'LIKE', "%{$validated['partner']}%"];
        }

        if (!empty($validated['name'])) {
            $search[] = ['name', 'LIKE', "%{$validated['name']}%"];
        }

        if (!empty($validated['cash']) && $validated['cash'] >= 0) {
            $search['cash'] = $validated['cash'];
        }

        if (!empty($validated['owner_id']) && $validated['owner_id'] >= 0) {
            $search['owner_id'] = $validated['owner_id'];
        }

        if (isset($validated['status']) && $validated['status'] >= 0) {
            $search['status'] = $validated['status'];
        }

        if (!empty($validated['created_at']) && count($validated['created_at'])) {
            $range = $validated['created_at'];
            $search[] = [DB::raw('date(created_at)'), '>=', $range[0]];
            $search[] = [DB::raw('date(created_at)'), '<=', $range[1]];
        }

        return $search;
    }
}
