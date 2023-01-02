<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request)
    {
        $where = [];
        if ($name = $request->input('name')) {
            $where[] = ['name', 'like', "%{$name}%"];
        }
    	$status = $request->input('status', -1);
    	if ($status >= 0) {
    	    $where['status'] = $status;
    	}

        $items = Brand::where($where)
            ->with('category')
            ->latest('sequence')
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * Select
     *
     */
    public function select(Request $request)
    {
        $search = [];
        if ($name = $request->input('name')) {
            $search[] = ['name', 'LIKE', "%{$name}%"];
        }

        $items = Brand::where($search)->limit(20)->get();

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
            'name' => 'required|min:2|max:50',
            'logo' => 'url',
            'sequence' => 'integer|min:0',
            'status' => 'in:0,1',
            'site' => 'url',
            'description' => 'string|max:500',
            'category_id' => 'nullable|integer|min:0'
        ]);

        if (Brand::whereName($request->input('name'))->exists()) {
            return fail('品牌名称已被占用');
        }

        $item = Brand::create($attributes);

        return success($item);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $item = Brand::findOrFail($id);
        $name = $request->input('name');
        if ($name && $name != $item->name) {
            if (Category::whereName($name)->exists()) {
                return fail('品牌名称已被占用');
            }
        }

        $attributes = $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'logo' => 'url',
            'sequence' => 'integer|min:0',
            'status' => 'in:0,1',
            'site' => 'url',
            'description' => 'string|max:500',
            'category_id' => 'nullable|integer|min:0'
        ]);

        $item->update($attributes);

        return success($item);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id)
    {
        $item = Brand::with('category')->findOrFail($id);

        return success($item);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(int $id)
    {
        $item = Brand::findOrFail($id);
        $item->delete();

        return success();
    }
}
