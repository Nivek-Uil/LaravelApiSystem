<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionsController extends Controller
{
    /**
     * 权限列表
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index()
    {
        // 获取全部权限列表
        return responseData(get_child(Permission::all(), 0));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->fill($request->all());

        try {
            $permission->save();
        } catch (\Exception $e) {
            Log::error('更新权限失败' . PHP_EOL .'Class: '. __CLASS__ . 'Line:' . $e->getLine() . PHP_EOL . $e->getMessage());
            return responseMessage('更新失败', 400);
        }

        return responseMessage('更新成功', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function destroy(Permission $permission)
    {
        //
        try {
            $permission->delete();
        } catch (\Exception $e) {
            Log::error('权限删除失败' . PHP_EOL .'Class: '. __CLASS__ . 'Line:' . $e->getLine() . PHP_EOL . $e->getMessage());
            return responseMessage('操作失败',400);
        }

        return responseMessage('删除成功',200);
    }
}
