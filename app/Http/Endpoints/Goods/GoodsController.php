<?php

namespace App\Http\Endpoints\Goods;

use App\Http\Endpoints\Controller;
use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = [];
        if ($name = $request->input('name')) {
            $search[] = ['name', 'LIKE', "%{$name}%"];
        }

        if ($createdAt = $request->input('created_at')) {
            list($start, $end) = $createdAt;
            $search[] = [DB::raw("LEFT(created_at, 10)"), '>=', $start];
            $search[] = [DB::raw("LEFT(created_at, 10)"), '<=', $end];
        }

        $status = $request->input('status', -1);
        if ($status != '' && $status >= 0) {
            $search['status'] = $status;
        }

        $product = $request->input('product_id', 0);
        if ($product) {
            $search['product_id'] = $product;
        }

        $brand = $request->input('brand_id', 0);
        if ($brand) {
            $search['brand_id'] = $brand;
        }

        $store = $request->input('store_id', 0);
        if ($store) {
            $search['store_id'] = $store;
        }

        $items = Goods::where($search)
            ->with(['brand', 'category', 'store', 'owner', 'delivery', 'product'])
            ->latest('sequence')
            ->oldest('status')
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        //
    }

    public function destroy(int $id): JsonResponse
    {
        $item = Goods::findOrFail($id);
        $item->delete();

        return success();
    }
}
