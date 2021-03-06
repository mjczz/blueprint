<?php

use App\Models\Image;
use App\Models\News;
use App\Models\Post;
use App\Models\Video;
use App\Services\ApiReturnService;
use App\User;
use Blueprint\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Faker\Generator as Faker;
use Illuminate\Support\Str;

Route::get('/', function (Faker $faker) {
    return view('welcome');
});

// redis执行lua脚本扣库存，测试超卖情况
Route::get('/decr_stock', function (Faker $faker) {
    $decrNum = rand(1, 100);
    $res = \App\Services\CommonService::decrStock('stock_key2', $decrNum);

    if ($res > 0) return '库存充足，扣除'.$decrNum.'后剩余:'.$res;

    return '库存不足，扣除'.$decrNum;
});

// redis执行lua脚本限流
Route::get('/redis_lua_req_limit', function (Faker $faker) {
    $key = 'limit_req_'.get_client_ip();
    $isLimited = \App\Services\CommonService::limitRequest($key, 10000, 30);

    if ($isLimited) {
        header('Is-Limited:1', true, 500);
        return '访问频率过大'.$key.'--'.$isLimited;
    }

    header('Is-Limited:0', true, 200);
    return '访问不受限制'.$key;
});

// 测试高并发扣库存操作-事务方式
Route::get('/test_redlock', function (Faker $faker) {
    $stock_key = 'stock_key';
    $remain_stock = Redis::get($stock_key);
    if ($remain_stock <= 0) dd('库存不足。。。。');

    \App\Services\RedisRedlockService::distributionLock('caogege-zhen-shuai', 1000, function ($lock_key, $lock, $start_time) use ($stock_key) {
        // 模拟处理时间，大于锁失效时间
        sleep(3);

        // 库存不足，直接返回
        $decr_num = rand(1, 10); // 模拟购买数量
        $remain_stock = Redis::get($stock_key);
        if ($remain_stock < $decr_num) dd('库存不足。。。。');

        // 扣库存操作
        Redis::multi();
        if (($b = Redis::decr($stock_key, $decr_num)) < 0) {
            // 库存不足，事务回滚
            Redis::discard();
            return '库存不足';
        }
        Redis::exec();

        // 记录一下库存的递减情况
        \Illuminate\Support\Facades\Log::info(
            "锁信息：".json_encode($lock_key).'---'.
            '库存减去'.$decr_num.'后的值：'.($b ?? null).'----'.
            '开始执行时间：'.$start_time.'----'.
            '结束执行时间：'. \Illuminate\Support\Carbon::now()
        );
    });
});

// 测试高并发扣库存操作-预扣库存方式
Route::get('/test_redlock2', function (Faker $faker) {
    $stock_key = 'stock_key';
    $remain_stock = Redis::get($stock_key);
    if ($remain_stock <= 0) dd('库存不足。。。。');

    \App\Services\RedisRedlockService::distributionLock('caogege-zhen-shuai', 1000, function ($lock_key, $lock, $start_time) use ($stock_key) {
        // 模拟处理时间，大于锁失效时间
        sleep(3);

        // 库存不足，直接返回
        $decr_num = rand(1, 10); // 模拟购买数量
        $remain_stock = Redis::get($stock_key);
        if ($remain_stock < $decr_num) dd('库存不足。。。。');

        // 预扣库存操作
        if (($b = Redis::decr($stock_key, $decr_num)) < 0) {
            // 加回去
            Redis::incr($stock_key, $decr_num);
            return '库存不足';
        }

        // 记录一下库存的递减情况
        \Illuminate\Support\Facades\Log::info(
            "锁信息：".json_encode($lock_key).'---'.
            '库存减去'.$decr_num.'后的值：'.($b ?? null).'----'.
            '开始执行时间：'.$start_time.'----'.
            '结束执行时间：'. \Illuminate\Support\Carbon::now()
        );
    });
});


// 测试高并发扣库存操作-直接使用decr预扣库存方式
Route::get('/test_redlock3', function (Faker $faker) {
    $start_time = \Illuminate\Support\Carbon::now();
    $stock_key = 'stock_key';
    $remain_stock = Redis::get($stock_key);
    if ($remain_stock <= 0) dd('库存不足。。。。');

    // 模拟处理时间，大于锁失效时间
    sleep(3);

    // 库存不足，直接返回
    $decr_num = rand(1, 10); // 模拟购买数量
    $remain_stock = Redis::get($stock_key);
    if ($remain_stock < $decr_num) dd('库存不足。。。。');

    // 预扣库存操作
    if (($b = Redis::decr($stock_key, $decr_num)) < 0) {
        $b = Redis::incr($stock_key, $decr_num);
    }

    // 记录一下库存的递减情况
    \Illuminate\Support\Facades\Log::info(
        '库存减去'.$decr_num.'后的值：'.($b ?? null).'----'.
        '开始执行时间：'.$start_time.'----'.
        '结束执行时间：'. \Illuminate\Support\Carbon::now()
    );
});



