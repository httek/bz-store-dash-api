<?php

namespace App\Http\Controllers;

use App\Http\Requests\Delivery\StoreRequest;
use App\Http\Requests\Delivery\UpdateRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($name = $request->input('name')) {
            $where[] = ['name', 'LIKE', "%{$name}%"];
        }

        if (($type = $request->input('type', -1)) >= 0) {
            $where['type'] = $type;
        }

        $items = Delivery::where($where)
            ->latest('sequence')
            ->latest('status')
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
            $where[] = ['name', 'LIKE', "%{$name}%"];
        }

        $items = Delivery::where($where)
            ->latest('sequence')
            ->latest('status')
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
        $items = Delivery::precise($key, $request->input('value'));

        return success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $name = $request->input('name');
        // 检测是否存在相同名称的记录
        $item = Delivery::create($request->validated());

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
        $item = Delivery::findOrFail($id);

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $item = Delivery::findOrFail($id);
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
        $item = Delivery::findOrFail($id);

        return $item->delete() ? success() : fail();
    }
}
