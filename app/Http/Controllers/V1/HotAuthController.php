<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\HotUser;
use Illuminate\Http\Request;

class HotAuthController extends ApiBaseController
{
    /**
     * 注册
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiCommonException
     */
    public function register(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
        ],[
            'mobile.required' => '手机号不能为空'
        ], $request->all());

        // TODO 验证app用户中是否有此用户
        $appUser = [
            'id' => 0,
            'red_bean_nums' => 0,
        ];

        // 检测用户是否已存在
        $info = HotUser::query()->where("mobile", trim($request['mobile']))->first();
        if (!empty($info)) api_err("用户已存在");

        $user = new HotUser();
        $user->mobile = trim($request->get('mobile'));
        $user->username = trim($request->get('mobile'));
        $user->app_user_id = $appUser['id'];
        $user->red_bean_nums = $appUser['red_bean_nums']; // 同步app user的红豆
        $user->save();

        // 颁发access_token
        $res = $this->returnWithToken($user);

        return $this->json($res);
    }

    /**
     * 登录
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiCommonException
     */
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
        ],[
            'mobile.required' => '手机号不能为空'
        ], $request->all());

        if (!$user = HotUser::query()->where('mobile', $request->mobile)->first()) api_err('未找到用户');

        // 颁发access_token
        $res = $this->returnWithToken($user);

        return $this->json($res);
    }

    private function returnWithToken(HotUser $user)
    {
        $tokenRes = $user->createToken(env("TOKEN_NAME"));

        return [
            'access_token' => $tokenRes->accessToken,
            'id' => $user->id,
            'username' => $user->username,
            'mobile' => $user->mobile,
        ];
    }

    /**
     * 忘记密码
     */
    public function forgetPass()
    {

    }

}
