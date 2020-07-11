<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/26
 * Time: 10:18
 */


use Illuminate\Support\Facades\Route;


Route::get('test/index', 'TestController@index');

Route::get('post/download', 'V1\PostController@download');
Route::apiResource('post', 'V1\PostController')->except('destroy');


Route::apiResource('news', 'V1\NewsController')->except('destroy');

    //->middleware("auth:api");

//Route::get('category/change-status/{category}', 'V1\CategoryController@changeStatus');
Route::apiResource('category', 'V1\CategoryController')->except('destroy');
    //->middleware("auth:api");
