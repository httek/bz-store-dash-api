<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($request->has('nav')) {
            $where['nav'] = 1;
        }

        if ($name = $request->input('name')){
             $where[] = ['name', 'like', "{$name}"];
        }

        $items = Tag::where($where)
            ->latest('sequence')
            ->latest('nav')
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated= $this->validate($request, [
            'name' => 'required|max:5|min:2',
            'cover' => 'nullable|url',
            'nav' => 'nullable|in:0,1',
            'sequence' => 'nullable|integer|min:0|max:999999'
        ]);

        $name = $request->input('name');
        if ($name && Tag::whereName($name)->exists()) {
            return fail('已存在该标签');
        }

        $tag = Tag::create($validated);

        return success($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Tag::findOrFail($id);

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Tag::findOrFail($id);
        $validated = $this->validate($request, [
            'name' => 'nullable|max:5|min:2',
            'cover' => 'nullable|url',
            'nav' => 'nullable|in:0,1',
            'sequence' => 'nullable|integer|min:0|max:999999'
        ]);

        $name = $request->input('name');
        if ($name
            && $name != $item->name
            && Tag::whereName($name)->where('id', '!=', $item->id)->exists()) {
            return fail('已存在该标签');
        }

        $item->update(array_filter($validated, function ($value) {
            return $value != null || $value != '';
        }));

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
        $item = Tag::findOrFail($id);

        return $item->delete() ? success() : fail();
    }
}
