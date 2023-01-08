<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Category\Store;
use App\Http\Requests\Category\Update;
use App\Http\Requests\Category\Search;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Search $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Search $request)
    {
        $items = Category::where($request->filter())
            ->latest('sequence')
            ->with('children')
            ->topLevel()
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(Store $request)
    {
        if (Category::whereName($request->input('name'))->exists()) {
            return fail('分类已存在');
        }

        $item = Model::create($request->validated());

        return success($item);
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

        return success(Category::precise($key, $value));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Model::findOrFail($id);

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Update $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Update $request, $id)
    {
        $item = Category::findOrFail($id);
        $name = $request->input('name');

        if ($name && $name != $item->name) {
            if (Category::whereName($name)->exists()) {
                return fail('分类已存在');
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
        /** @var Category $item */
        $item = Category::findOrFail($id);
        switch ($item->type) {
            case 1:
                if ($item->hasGoodsUsages())
                    return fail("该分类存在商品关联、无法删除");

                if ($item->hasProductUsages())
                    return fail("该分类存在产品关联、无法删除");

                break;
            case 2:
                if ($item->hasBrandUsages())
                    return fail("该分类存在品牌关联、无法删除");

                break;
        }

        return $item->delete() ? success() : fail();
    }
}
