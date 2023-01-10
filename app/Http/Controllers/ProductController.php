<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\Store;
use App\Http\Requests\Product\Search;
use App\Http\Requests\Product\Update;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Search $request)
    {
        $where = $request->filter();

        $items = Product::where($where)
            ->with('category')
            ->latest('sequence')
            ->latest('status')
            ->latest()
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
        if (Product::whereName($request->input('name'))->exists()) {
            return fail('已存在该产品');
        }

        $item = Product::create($request->validated());

        return success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Product::with('category')->findOrFail($id);

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
        $item = Product::with('category')->findOrFail($id);
        if ($item->ifExists($request->input('name'))) {
            return fail('已存在该产品');
        }

        $updated = $item->update($request->validated());

        return $updated ? success($item) : fail();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::with('category')->findOrFail($id);
        if ($item->goods()->count()) {
            return fail('存在商品关联，无法删除');
        }

        return $item->delete() ? success() : fail();
    }
}
