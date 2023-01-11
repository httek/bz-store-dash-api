<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function select(Request $request)
    {
        $where = [];
        if (($status = $request->input('status', -1)) >= 0) {
            $where['status'] = $status;
        }
        if ($name = $request->input('name')) {
            $where[] = ['name', 'LIKE', "%{$name}%"];
        }

        $items = Product::with('category')
            ->where($where)
            ->latest('sequence')
            ->latest('status')
            ->latest()
            ->select(['id', 'name', 'covers', 'status', 'category_id'])
            ->get();

        return success($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function precise(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        $items = Product::precise($key, $value);

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
        $name = $request->input('name');
        if (Product::whereName($name)->exists()) {
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
        $item = Product::findOrFail($id);
        if ($item->goods()->count()) {
            return fail('存在商品关联，无法删除');
        }

        return $item->delete() ? success() : fail();
    }
}
