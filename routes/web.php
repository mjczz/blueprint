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
    $stock_num = 30;
    $stock_key = 'stock_key';

    // 初始化库存
    //return \Illuminate\Support\Facades\Redis::set($stock_key, $stock_num);

    $remind_stock = \Illuminate\Support\Facades\Redis::get($stock_key);
    if ($remind_stock <= 0) dd('库存不足。。。。');

    \App\Services\RedisRedlockService::distributionLock('test_redlock', 1000, function ($lock, $start_time) use ($stock_key) {
        // 模拟处理时间，大于锁失效时间
        sleep(6);

        $v = \Illuminate\Support\Facades\Redis::get($stock_key);
        if ($v - 1 >= 0) {
            // 扣库存操作
            $b = \Illuminate\Support\Facades\Redis::decr($stock_key);
        }

        \Illuminate\Support\Facades\Log::info(
            "锁信息：".json_encode($lock).'---'.
            '库存减去1后的值：'.($b ?? null).'----'.
            '开始执行时间：'.$start_time.'----'.
            '结束执行时间：'. \Illuminate\Support\Carbon::now()
        );
    });
});



