<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Store;
use App\Http\Requests\Admin\Update;
use App\Http\Requests\Admin\Search;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * @param Search $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Search $request)
    {
        $items = Admin::with(['role'])
            ->where($request->filter())
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * @param Store $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(Store $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $item = Admin::create($data);

        return success($item);
    }

    /**
     * @param Update $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Update $request, int $id)
    {
        $item = Admin::findOrFail($id);
        $upData = $request->validated();
        if (!empty($upData['password'])) $upData['password'] = Hash::make($item['password']);

        $item->update($upData);

        return success($item);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id)
    {
        $item = Admin::with(['role'])->findOrFail($id);

        return success($item);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(int $id)
    {
        $item = Admin::with(['role'])->findOrFail($id);

        // check refs
        // flush sessions.
        return $item->delete() ? success() : fail();
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
        $this->validate($request, ['type' => 'in:-1,1,2']);
        if (($type = $request->input('type', 1)) >= 0) {
            $where['type'] = $type;
        }

        if ($name = $request->input('name')) {
            $where[] = ['name', 'like', "%{$name}%"];
        }

        $items = Admin::where($where)->get();

        return success($items);
    }
}
