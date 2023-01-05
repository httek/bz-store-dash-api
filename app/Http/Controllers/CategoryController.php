<?php

namespace App\Http\Controllers;

use App\Models\Category as Model;
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
        $items = Model::where($request->condition())
            ->latest('sequence')
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
        return success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Category::findOrFail($id);

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
        $item = Category::findOrFail($id);

        return success($item);
    }
}
