<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;
use App\models\LoginLog;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function App\Helpers\get_child;
use function App\Helpers\responseData;
use function App\Helpers\responseMessage;

class AuthorizationsController extends Controller
{
    /**
     * 获取授权（登录）
     * @param AuthorizationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function store(AuthorizationRequest $request)
    {
        if (config('app.image_captcha')) {
            if (!$request->captcha_key || empty($request->captcha_code)) {
                abort(400, '请输入验证码');
            }
            $captchaData = Cache::get($request->captcha_key,null);

            if (!$captchaData) {
                abort(400, '图片验证码已失效');
            }

            if (!hash_equals(strtolower($captchaData['code']), strtolower($request->captcha_code))) {
                abort(400, '验证码错误');
            }

            Cache::forget($request->captcha_key);
        }

        $credentials['account'] = $request->account;
        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('user')->attempt($credentials)) {
            Cache::forget($request->captcha_key);
            throw new AuthenticationException('用户名或密码错误');
        }

        // 保存登录日志
        LoginLog::create([
            'user_id' => $request->user('user')->id,
            'account' => $request->user('user')->account,
            'ip' => $request->ip(),
            'method' => $request->method(),
            'user_agent' => $request->header('User-Agent'),
            'remark' => '登录成功',
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * 更新token
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $token = auth('user')->refresh();
        return $this->respondWithToken($token);
    }

    /**
     * 删除token（退出登录）
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy()
    {
        auth('user')->logout();
        return response(['success'], 200);
    }

    /**
     *
     */
    public function info()
    {
        $user = clone Auth::user('user');
        // 个人基本信息
        $data['info'] = $user;

        $login_log = LoginLog::where(['account' => $user['account']])->orderBy('created_at','desc')->get()->toArray();

        $data['info']['last_login_ip'] = $login_log[1]['ip'] ?? '';
        $data['info']['last_login_time'] = $login_log[1]['created_at'] ?? '';

        // 获取全部角色
        $data['roles'] = Auth::user('user')->getRoleNames();
        // 获取全部权限
        $data['permissions'] = get_child(Auth::user('user')->getAllPermissions(), 0);
        return responseData($data);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 60
        ]);
    }
}
