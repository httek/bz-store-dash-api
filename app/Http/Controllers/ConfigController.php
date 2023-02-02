<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if (($group = $request->input('group', -1)) >= 0) {
            $where['group'] = $group;
        }

        $items = Config::where($where)
            ->where(function ($query) use ($request) {
                if ($keys = $request->input('keys', [])) {
                    $query->whereIn('key', $keys);
                }
            })
            ->get();

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
        $this->validate($request, [
            'type' => 'required|in:array,object,string,integer,bool,boolean',
            'key' => 'required'
        ]);
        
        $new = $request->only(['key', 'value', 'group', 'type']);
        $item = Config::create($new);

        return success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $key)
    {
        $item = Config::where('key', $key)->firstOrFail();

        return success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $key)
    {
        $item = Config::where('key', $key)->firstOrFail();
        $item->update(['value' => $request->input('value')]);

        return success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return Config::where('id', $id)->delete()
            ? success() : fail();
    }
}
