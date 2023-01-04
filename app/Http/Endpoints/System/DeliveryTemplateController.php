<?php

namespace App\Http\Endpoints\System;

use App\Http\Endpoints\Controller;
use App\Http\Requests\Delivery\SearchRequest;
use App\Http\Requests\Delivery\StoreRequest;
use App\Http\Requests\Delivery\UpdateRequest;
use App\Models\DeliveryTemplate;

class DeliveryTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        $search = [];
        $type = $request->input('type', -1);
        if ($name = $request->input('name')) $search[] = ['name', 'LIKE', "%{$name}%"];
        if ($type >= 0) $search['type'] = $type;


        $items = DeliveryTemplate::latest('sequence')
            ->where($search)
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (DeliveryTemplate::whereName($request->input('name'))->exists()) {
            return fail('已存在相同名称的配送方式');
        }

        $item = DeliveryTemplate::create($request->validated());

        return success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DeliveryTemplate $deliveryTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $item = DeliveryTemplate::findOrFail($id);

        return success($item);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $item = DeliveryTemplate::findOrFail($id);
        $item->update($request->validated());

        return success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DeliveryTemplate $deliveryTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        DeliveryTemplate::destroy($id);

        return success();
    }
}
