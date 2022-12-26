<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\AddStoreRequest;
use App\Http\Requests\Store\FilterStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterStoreRequest $request)
    {
        $search = $request->getFilterAttributes();
        $items = Store::where($search)
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
    public function store(AddStoreRequest $request)
    {
        $attributes = $request->validated();

        $item = Store::create($attributes);

        return success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $item = Store::findOfFail($id);

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, int $id)
    {
        $item = Store::findOrFail($id);
        $attributes = $request->validated();
        $item->update($attributes);

        return success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(id $id)
    {
        $item = Store::findOrFail($id);
        $item->delete();

        return success();
    }
}
