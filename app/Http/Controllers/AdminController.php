<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Endpoints\Controller;
use App\Http\Requests\Admin\Search;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @param Search $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Search $request)
    {
        $items = Admin::where($request->filter())
            ->whereStatus(1)
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * Select admins with type.
     *
     * @param \Illuminate\Http\Request $request
     *
     */
    public function select(Request $request)
    {
        // 1 admin, 2 store owner
        $type = $request->input('type', 1);
        $items = Admin::whereType($type)
            ->get();

        return success($items);
    }
}
