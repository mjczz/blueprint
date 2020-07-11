<?php

namespace App\Traits;
use App\Exceptions\ApiCommonException;
use Illuminate\Support\Facades\Request;
use function is_object;
use const PHP_EOL;

trait ApiReturn
{
    /**
     * 操作成功
     *
     * @param int    $code
     * @param string $message
     * @param array  $data
     *
     * @return \think\response\Json
     */
    public function sucess($code = 200, $message = '操作成功', $data = [])
    {
        return $this->json($data, $code, $message);
    }

    /**
     * 操作失败
     *
     * @param int    $code
     * @param string $message
     * @param array  $data
     *
     * @return \think\response\Json
     */
    public function fail($message = '操作失败', $code = 400, $message_string = '系统异常', $data = [], $debug_msg = '')
    {
        is_string($message) && $message_string = $message;

        if (is_object($message) && $message instanceof \Throwable) {
            if ($message instanceof ApiCommonException) {
                $message_string = $message->getMessage();
            } else {
                $debug_msg = "报错信息：" .$message->getMessage()."  ".PHP_EOL;
                $debug_msg .= "报错文件：".$message->getFile()."  ".PHP_EOL;
                $debug_msg .= "报错行：".$message->getLine();
            }
        }

        return $this->json($data, $code, $message_string, $debug_msg);
    }

    /**
     * @param $data
     * @param $paginator \Illuminate\Pagination\LengthAwarePaginator
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate($data, $paginator)
    {
        return $this->json([
            'total' => $paginator->total(),
            'page' => $paginator->currentPage(),
            'limit' => $paginator->perPage(),
            'list' => $data,
        ]);
    }

    /**
     * @param array  $data
     * @param int    $code
     * @param string $message
     * @param string $debug_msg
     * @param int    $http_code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], $code = 200, $message = '查询成功', $debug_msg = '', $http_code = 200)
    {
        if (!config('app.debug')) {
            $debug_id = uniqid();

            parse_str(Request::getContent(), $post_field);

            \Log::debug($debug_id,[
                'LOG_ID'         => $debug_id,
                'IP_ADDRESS'     => Request::ip(),
                'REQUEST_URL'    => Request::fullUrl(),
                'AUTHORIZATION'  => Request::header('Authorization'),
                'REQUEST_METHOD' => Request::method(),
                'PARAMETERS'     => ['query_string' => Request::getQueryString(), 'post_fields' => $post_field],
                'RESPONSES'      => $data
            ]);
        }

        $body = [
            'code' => $code,
            'msg' => $message,
            'data' => $data,
            'debug_msg' => $debug_msg
        ];

        return response()->json($body, $http_code);
    }

}
