<?php

namespace App\Http\Controllers;

use App\Http\Requests\Block\Search;
use App\Http\Requests\Block\Store;
use App\Http\Requests\Block\Update;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Search $search
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Search $search)
    {
        $items = Block::where($search->filter())
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
    public function store(Store $request)
    {
        if (Block::whereName($request->input('name'))->exists()) {
            return fail('分类已存在');
        }

        $item = Block::create($request->validated());

        return success($item);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function select(Request $request)
    {
        $where = [];
        $items = Block::where($where)
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

        return success(Block::precise($key, $value));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Block::findOrFail($id);

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, int $id)
    {
        $item = Block::findOrFail($id);
        $name = $request->input('name');
        if ($name && $name != $item->name) {
            if (Block::whereName($name)->exists()) {
                return fail('名称已存在');
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
        $item = Block::findOrFail($id);

        return $item->delete() ? success() : fail();
    }
}
