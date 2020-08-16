<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/26
 * Time: 10:18
 */


use Illuminate\Support\Facades\Route;

Route::get('demo/list', 'V1\DemoController@listData');
Route::apiResource('demo', 'V1\DemoController');
Route::apiResource('movie', 'V1\MovieController')->except('destroy');
Route::apiResource('blog', 'V1\BlogController')->except('destroy');
Route::apiResource('news', 'V1\NewsController');

Route::post('hot_user_register', 'V1\HotAuthController@register');
Route::post('hot_user_login', 'V1\HotAuthController@login');

Route::group(['middleware' => ['auth:hot'], 'namespace' => 'V1'], function () {
    Route::get('options', 'CommonController@options'); // 数据字典

    Route::put('hot_publish_order/{hot_publish_order}/lock_order', 'HotPublishOrderController@lockOrder'); // 锁单
    Route::apiResource('hot_publish_order', 'HotPublishOrderController');

    Route::put('hot_user_order/{hot_user_order}/confirm_pay', 'HotPublishOrderController@confirmPay'); // 确认付款(买方)
    Route::put('hot_user_order/{hot_user_order}/confirm_ship', 'HotPublishOrderController@confirmShip'); // 确认收货(买方)
    Route::put('hot_user_order/{hot_user_order}/cancel_order', 'HotPublishOrderController@cancelOrder'); // 取消订单(买方)
    Route::put('hot_user_order/{hot_user_order}/upload_pay_attach', 'HotPublishOrderController@uploadPayAttach'); // 上传打款凭证(买方)
    Route::put('hot_user_order/{hot_user_order}/complain', 'HotPublishOrderController@complain'); // 申诉(买方)
    Route::put('hot_user_order/{hot_user_order}/confirm_payed', 'HotPublishOrderController@confirmPayed'); // 确认收款(卖方)
    Route::put('hot_user_order/{hot_user_order}/give_hot', 'HotPublishOrderController@giveHot'); // 释放hot(卖方)

    Route::apiResource('hot_user', 'HotUserController'); // 用户
    Route::apiResource('hot_pay_account', 'HotPayAccountController'); // 用户支付账号
    Route::apiResource('hot_user_order', 'HotUserOrderController'); // 用户订单列表
    Route::apiResource('hot_complain', 'HotComplainController'); // 订单申诉
    Route::apiResource('hot_bean_exchange', 'HotBeanExchangeController'); // 兑换记录
});

