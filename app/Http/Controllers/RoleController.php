<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Role\Store;
use App\Http\Requests\Role\Update;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($title = $request->input('name')) {
            $where[]= ['name', 'like', "%{$title}%"];
        }
        if (($status = $request->input('status', -1)) >= 0) {
            $where['status'] = $status;
        }

        $items = Role::oldest()
            ->where($where)
            ->paginate($this->getPageSize());

        return success($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function select(Request $request)
    {
        $items = Role::where('id', '>', 1)
            ->select(['id', 'name'])
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
            'key' => 'required', 'value' => 'required'
        ]);

        $key = $request->input('key');
        $value = $request->input('value');

        return success(Role::precise($key, $value));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $item = Role::create($request->validated());

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
        $item = Role::findOrFail($id);
        $item->permissionIds = PermissionRole::where('role_id', $item->id)
            ->pluck('permission_id');

        return success($item);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function attachPermission(Request $request, int $id)
    {
        $item = Role::findOrFail($id);
        $this->validate($request, [
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer'
        ]);

        $permissions = [];
        foreach ($request->input('permissions') as $id) {
            $permissions[] = ['role_id' => $item->id, 'permission_id' => $id];
        }

        PermissionRole::where('role_id', $item->id)->delete();
        $permissions && PermissionRole::insert($permissions);

        return success();
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
        $item = Role::findOrFail($id);
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
        $item = Role::findOrFail($id);
        // check refs.
        // flush admin sessions.

        return $item->delete() ? success() : fail();
    }
}
