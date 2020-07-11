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
    //$yourModel = new \App\Models\Test();
    //$yourModel->extra_attributes->name = "value";

    //$res = $yourModel->withExtraAttributes(['name' => 'value', 'name2' => 'value2'])->get();
    //$res = $yourModel->withExtraAttributes(['name' => 'value'])->get();
    //return $res;
    //$yourModel->extra_attributes->name;
    //$yourModel->save();
    //return $yourModel;


    $a = __('admin.created_at');
    dd($a);
    //$res =factory(  News::class,100)->create();
    return $res;
    //$res = factory(User::class, 100)->create();
    //$res = factory(\App\Models\Post::class, 100)->create();
    //return \App\Http\Resources\Post::collection($res);
    //$res = factory(\App\Models\Video::class, 10)->create();
    //$res = factory(\App\Models\Category::class, 100)->create();
    //return $res;
    //
    $video = Video::find(1);
    $video->image()->create([
        'name' => $faker->name,
        'url' => $faker->url,
    ]);


    return view('welcome');
});

Route::any('/unauth', function() {
    return ApiReturnService::fail('unAuth', '401');
})->name('unAuth');

