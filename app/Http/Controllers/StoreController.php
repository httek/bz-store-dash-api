<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\Store\Update;
use App\Http\Requests\Store\Search;
use App\Http\Requests\Store\Store as StoreRequest;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Search $search)
    {
        $items = Store::where($search->filter())
            ->latest('sequence')
            ->with('owner')
            ->paginate($this->getPageSize());

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
        if (Store::whereName($name)->exists()) {
            return fail('店铺名称已存在');
        }

        $item = Store::create($request->validated());

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
        $item = Store::with('owner')->findOrFail($id);

        return success($item);
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

        $items = Store::where($where)
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

        return success(Store::precise($key, $value));
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
        $item = Store::findOrFail($id);
        $name = $request->input('name');
        if ($name && $name != $item->name) {
            if (Store::whereName($name)->exists()) {
                return fail('店铺名称已存在');
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
        $item = Store::findOrFail($id);

        return $item->delete() ? success() : fail();
    }
}
