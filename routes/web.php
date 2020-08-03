<?php

use App\Models\Image;
use App\Models\News;
use App\Models\Post;
use App\Models\Video;
use App\Services\ApiReturnService;
use App\User;
use Blueprint\Blueprint;
use Illuminate\Support\Facades\Route;

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

// 测试高并发扣库存操作
Route::get('/test_redlock', function (Faker $faker) {
    $stock_key = 'stock_key';
    $remain_stock = \Illuminate\Support\Facades\Redis::get($stock_key);
    if ($remain_stock <= 0) dd('库存不足。。。。');

    \App\Services\RedisRedlockService::distributionLock('caogege-zhen-shuai', 1000, function ($lock_key, $lock, $start_time) use ($stock_key) {
        // 模拟处理时间，大于锁失效时间
        sleep(3);

        // 库存不足，直接返回
        $decr_num = rand(1, 10); // 模拟购买数量
        $remain_stock = \Illuminate\Support\Facades\Redis::get($stock_key);
        if ($remain_stock < $decr_num) dd('库存不足。。。。');

        // 扣库存操作
        if (($b = \Illuminate\Support\Facades\Redis::decr($stock_key, $decr_num)) < 0) {
            // 库存不足，直接返回
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



