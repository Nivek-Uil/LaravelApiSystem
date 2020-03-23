<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use function App\Helpers\responseMessage;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //  当请求为api时，自定义异常返回格式
        if ($request->expectsJson()) {
            if ($exception instanceof AuthenticationException) {
                if ($exception->getMessage() === 'Unauthenticated.') {
                    $mag = '未登录或登录过期';
                } else {
                    $mag = $exception->getMessage();
                }
                return responseMessage($mag, 401, 401);
            }
            // 没有权限的异常处理
            if ($exception instanceof UnauthorizedException) {
                return responseMessage('没有权限', 403, 403);
            }
            if ($exception instanceof HttpException) {
                return responseMessage($exception->getMessage(), $exception->getStatusCode(), $exception->getStatusCode());
            }
            // 自定义验证失败的返回信息
            if ($exception instanceof ValidationException) {
                $errors = @$exception->validator->errors()->toArray();

                $msg = [];
                foreach (array_values($errors) as $array_value) {
                    foreach ($array_value as $item) {
                        $msg[] = $item;
                    }
                }
                return responseMessage($msg, 422, 422);
            }
        }

        return parent::render($request, $exception);
    }
}
