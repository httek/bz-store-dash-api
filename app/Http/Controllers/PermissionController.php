<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\Store;
use App\Http\Requests\Permission\Update;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($name = $request->input('name')) {
            $where[] = ['title', 'like', "%{$name}%"];
        }

        $items = Permission::with('children')
            ->where($where)
            ->latest('sequence')
            ->whereNull('parent_id')
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
        $this->validate($request, [
            'key' => 'required', 'value' => 'validate'
        ]);

        $key = $request->input('key');
        $value = $request->input('value');

        return success(Permission::precise($key, $value));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $item = Permission::create($request->validated());

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
        $item = Permission::with('children')->findOrFail($id);

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
        $item = Permission::findOrFail($id);
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
        $item = Permission::findOrFail($id);
        if ($item->children()->count()) {
            return fail('存在子级权限，无法删除');
        }

        PermissionRole::where('permission_id', $item->id)->delete();

        return $item->delete() ? success() : fail();
    }
}
