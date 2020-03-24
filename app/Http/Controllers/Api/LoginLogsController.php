<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use function App\Helpers\responseData;

class LoginLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index()
    {
        //
        $limit = $this->param['limit'] ?? 10;

       $data =  LoginLog::paginate($limit);

        return responseData($data);
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
     * @param  \App\Models\LoginLog  $loginLog
     * @return \Illuminate\Http\Response
     */
    public function show(LoginLog $loginLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoginLog  $loginLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoginLog $loginLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoginLog  $loginLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoginLog $loginLog)
    {
        //
    }
}
