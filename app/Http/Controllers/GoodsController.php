<?php

namespace App\Http\Controllers;

use App\Http\Requests\Goods\Search;
use App\Models\Goods;
use App\Http\Requests\Goods\Store;
use App\Http\Requests\Goods\Update;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Search $search)
    {
        $where = $search->filter();
        $items = Goods::with(['product', 'store', 'category', 'brand'])
            ->where($where)
            ->latest('sequence')
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
        if ($name = $request->input('name')) {
            $where[] = ['name', 'like', "%{$name}%"];
        }

        $items = Goods::with(['product', 'store', 'category', 'brand'])
            ->where($where)
            ->latest('sequence')
            ->limit(20)
            ->get();

        if ($request->has('id')) {
            $idArr = explode(',', $request->input('id'));
            $ids = array_diff($idArr, $items->pluck('id')->toArray());
            $appends = Goods::with(['product', 'store', 'category', 'brand'])->find($ids);
            $appends && $items->push(...$appends);
        }

        return success($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function precise(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'value' => 'required'
        ]);

        $name = $request->input('name');
        $value = $request->input('value');
        $items = Goods::precise($name, $value);

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
        $item = Goods::with(['product', 'category', 'store', 'brand', 'delivery'])->findOrFail($id);

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
