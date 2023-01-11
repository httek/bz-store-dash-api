<?php

namespace App\Http\Controllers;

use App\Http\Requests\Goods\Search;
use App\Models\Goods;
use App\Http\Requests\Goods\Store;
use App\Http\Requests\Goods\Update;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Search $search)
    {
        $where = []; // TODO: Goods
        $items = Goods::with(['product', 'store', 'category', 'brand'])
            ->where($where)
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
        $item = Goods::create($request->validated());

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
        $item = Goods::findOrFail($id);

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
        $item = Goods::findOrFail($id);
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
        $item = Goods::findOrFail($id);

        return $item->delete() ? success() : fail();
    }
}
