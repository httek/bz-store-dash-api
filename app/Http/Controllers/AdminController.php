<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Endpoints\Controller;
use App\Http\Requests\Admin\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
        $where = ['type' => $request->input('type', 1)];
        $key = $request->input('key');
        $value = $request->input('value');
        $table = (new Admin)->getTable();
        if ($key && $value && Schema::hasColumn($table, $key)) {
            $where[$key] = $value;
        }

        $items = Admin::where($where)->get();

        return success($items);
    }
}
