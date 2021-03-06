<?php

namespace App\Exceptions;

use App\Traits\ApiReturn;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiReturn;

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
     * @param  \Throwable  $exception
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (strpos($request->route()->getPrefix(), 'v1') !== false) {
            // 路由模型绑定查询不到数据异常
            if ($exception instanceof ModelNotFoundException ) {
                switch($request->getMethod()) {
                    case 'GET':
                        return $this->json(null);
                    case 'DELETE':
                    case 'PUT':
                        return $this->fail('数据不存在');
                    default:
                        return $this->fail("我喜欢关之琳，赵丽颖");
                }
            }

            // 表单验证异常
            if ($exception instanceof ValidationException) {
                return $this->fail($exception->validator->errors()->first());
            }

            if ($exception instanceof AuthenticationException) {
                return $this->fail('认证失败', '401');
            }

            return $this->fail($exception);
        }

        return parent::render($request, $exception);
    }
}
