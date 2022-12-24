<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SearchRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        $search = ['type' => $request->input('type', 0)];
        if ($name = $request->input('name')) {
            $search[] = ['name', 'LIKE', "%{$name}%"];
        }

        $items = Category::where($search)
            ->whereLevel(1)
            ->latest('sequence')
            ->with(['children' => function($query) { $query->with('children'); }])
            ->get();

        return success($items);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function select()
    {
        $items = Category::whereLevel(1)
            ->with('children')
            ->latest('sequence')
            ->whereStatus(1)
            ->get();

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
        $attributes = $request->validated();
        $parent = !empty($attributes['parent'])
            ? Category::find($attributes['parent'])
            : null;

        if ($parent) {
            $attributes['level'] = $parent->level + 1;
        }

        $item = Category::create($attributes);

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
        $item = Category::findOrFail($id);

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
        $item = Category::findOrFail($id);
        $attributes = $request->validated();
        if (!empty($attributes['parent']) && $attributes['parent'] != $item->parent) {
            $attributes['level'] = (Category::find($attributes['parent'])->level ?? 0) + 1;
        }
        $item->update($attributes);
        return success();
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
        $item->children()->delete();
        $item->delete();

        return success();
    }
}
