<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        $this->validate($request, ['status' => 'in:-1,0,1,2', 'name' => 'string|max:60']);

        $search = [];
        if ($name = $request->input('name')) {
            $search[] = ['name', 'like', "%{$name}%"];
        }
        if (($status = $request->input('status')) >= 0) {
            $search['status'] = $status;
        }

        $items = Product::where($search)
            ->with('category')
            ->latest('sequence')
            ->latest()
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $attributes = $this->validate($request, [
            'name' => 'required|string|min:2|max:60',
            'category_id' => 'nullable|integer|min:0',
            'images' => 'array',
            'images.*' => 'url',
            'description' => 'string|max:400',
            'status' => 'in:0,1,2',
            'sequence' => 'integer|min:0'
        ]);

        if (Product::whereName($request->input('name'))->exists()) {
            return fail('产品名称已存在');
        }

        $item = Product::create($attributes);

        return success($item);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $item = Product::findOrFail($id);

        $attributes = $this->validate($request, [
            'name' => 'string|min:2|max:60',
            'category_id' => 'nullable|integer|min:0',
            'images' => 'array',
            'images.*' => 'url',
            'description' => 'string|max:400',
            'status' => 'in:0,1,2',
            'sequence' => 'integer|min:0'
        ]);

        if (
            $request->has('name') &&
            $item->name != $request->input('name') &&
            Product::whereName($request->input('name'))->exists()
        ) {
            return fail('产品名称已存在');
        }

        $item->update($attributes);
        // 其他状态检测

        return success($item);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(int $id)
    {
        $item = Product::findOrFail($id);

        $item->delete();
        // 其他关联操作

        return success();
    }
}
