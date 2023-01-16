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
        $items = Tag::where($where)
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
        $items = Tag::latest('sequence')->select(['id', 'name', 'cover'])->get();

        return success($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function precise(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');

        return success(Tag::precise($key, $value));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'cover' => 'nullable|url',
            'sequence' => 'nullable|integer'
        ]);

        $item = Tag::create($validated);

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
            'name' => 'required',
            'cover' => 'nullable|url',
            'sequence' => 'nullable|integer'
        ]);
        $item->update($validated);

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

        $item->delete();

        return success();
    }
}
