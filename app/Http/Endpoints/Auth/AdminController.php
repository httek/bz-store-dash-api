<?php

namespace App\Http\Endpoints\Auth;

use App\Http\Endpoints\Controller;
use App\Http\Requests\Auth\SearchAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(SearchAdminRequest $request)
    {
        $search = $request->getSearches();
        $items = Admin::where($search)
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
        $type = $request->input('type', 1);
        $items = Admin::whereType($type)->get();

        return success($items);
    }
}
