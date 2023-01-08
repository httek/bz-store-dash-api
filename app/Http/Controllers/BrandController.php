<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\Update;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\Brand\Store;
use App\Http\Requests\Brand\Search;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Search $search
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Search $search)
    {
        $items = Brand::where($search->filter())
            ->latest('sequence')
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        if (Brand::whereName($request->input('name'))->exists()) {
            return fail('分类已存在');
        }

        $item = Brand::create($request->validated());

        return success($item);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function select(Request $request)
    {
        $where = [];
        $items = Brand::where($where)
            ->latest('sequence')
            ->get();

        return success($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function precise(Request $request)
    {
        $precise = $this->validate($request, ['key' => 'required', 'value' => 'required']);
        extract($precise);

        return success(Brand::precise($key, $value));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Brand::findOrFail($id);

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $item = Brand::findOrFail($id);
        $name = $request->input('name');
        if ($name && $name != $item->name) {
            if (Brand::whereName($name)->exists()) {
                return fail('品牌名称已存在');
            }
        }

        $item->update($request->validated());

        return success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Brand::findOrFail($id);
        if ($item->products()->count()) {
            return fail('存在产品关联，无法删除');
        }

        return $item->delete() ? success() : fail();
    }
}
