<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;
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

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 60
        ]);
    }
}
