<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\AddStoreRequest;
use App\Http\Requests\Store\FilterStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
            ->with('deliveryTemplate')
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

        $items = Store::where($search)->limit(20)->get();

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
        $item = Store::findOrFail($id);

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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function precisSearch(Request $request)
    {
        $precis = $this->validate($request, ['key' => 'required|string', 'value' => 'required']);
        $results = null;
        $model = new Store();
        $columns = Schema::getColumnListing($model->getTable());
        if (! in_array($precis['key'], $columns)) {
            return success($results);
        }

        $select = $request->input('fields', [$precis['key']]);
        $results = $model->where($precis['key'], $precis['value'])
            ->select($select)
            ->get();

        return success($results);
    }
}
