<?php

namespace App\Http\Controllers;

use App\Http\Requests\Swiper\Search;
use App\Http\Requests\Swiper\Store;
use App\Http\Requests\Swiper\Update;
use App\Models\Swiper;
use Illuminate\Http\Request;

class SwiperController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Search $search
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Search $search)
    {
        $items = Swiper::where($search->filter())
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
        $item = Swiper::create($request->validated());

        return success($item);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function select(Request $request)
    {
        $where = [];
        $items = Swiper::where($where)
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

        return success(Swiper::precise($key, $value, $request->input('ignore', 0)));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Swiper::findOrFail($id);

        return success($item);
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
        $item = Swiper::findOrFail($id);

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
        $item = Swiper::findOrFail($id);

        return $item->delete() ? success() : fail();
    }
}
