<?php

use App\Exceptions\ApiCommonException;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;

/**
 * 获取客户端 ip
 * @return array|false|null|string
 */
function get_client_ip()
{
    static $realip = NULL;
    if ($realip !== NULL) {
        return $realip;
    }
    //判断服务器是否允许$_SERVER
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        //不允许就使用getenv获取
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }

    return $realip;
}

// 获取表结构、字段类型
function tableSchema($table)
{
    $table = trim($table);
    $sql = "SELECT column_name,data_type,CHARACTER_MAXIMUM_LENGTH
            FROM information_schema.COLUMNS
            WHERE TABLE_NAME = '{$table}'";
    return DB::select($sql);
}

function api_err($message = "操作失败") {
    throw new ApiCommonException($message);
}

function options($key = null) {
    return CommonService::getOptions($key);
}

function transaction(\Closure $closure) {
    try {
        DB::beginTransaction();

        $res = $closure();

        DB::commit();

        return $res;
    } catch (\Throwable $t) {
        DB::rollback();

        throw $t;
    }
}
