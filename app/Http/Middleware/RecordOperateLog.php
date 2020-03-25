<?php

namespace App\Http\Middleware;

use App\Models\OperateLog;
use Closure;
use Illuminate\Support\Facades\Route;

class RecordOperateLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($request->getMethod() !== 'GET') {
        if (Route::currentRouteName() !== 'api.authorization'){
            OperateLog::create([
                'user_id' => $request->user()->id,
                'account' => $request->user()->account,
                'uri' => $request->getRequestUri(),
                'host' => $request->getHost(),
                'route_name' => Route::currentRouteName(),
                'method' => $request->getMethod(),
                'ip' => $request->getClientIp(),
                'parameter' => http_build_query($request->except(['_token', '_method'])),
                'user_agent' => $request->userAgent()
            ]);
        }

//        }

        return $next($request);
    }
}
