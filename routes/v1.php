<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/26
 * Time: 10:18
 */


use Illuminate\Support\Facades\Route;

Route::apiResource('demo', 'V1\DemoController');
Route::apiResource('movie', 'V1\MovieController')->except('destroy');
Route::apiResource('blog', 'V1\BlogController')->except('destroy');
Route::apiResource('news', 'V1\NewsController')->except('destroy');
