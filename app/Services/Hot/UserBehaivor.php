<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/8/15
 * Time: 17:36
 */

namespace App\Services\Hot;

use App\Models\HotPublishOrder;
use App\Models\HotUser;
use App\Models\HotUserOrder;
use App\Services\CommonService;
use App\Services\Hot\OrderService;
use App\Services\SettingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use function api_err;
use function e;

class UserBehaivor
{
    /**
     * 发布订单
     *
     * @param HotUser $user
     * @param         $price
     * @param         $nums
     * @param         $order_type
     * @param         $order_amount_type
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function pubOrder(HotUser $user, $price, $nums, $order_type, $order_amount_type)
    {
        // 卖单
        if ($order_type == HotPublishOrder::ORDER_TYPE_SALE) {
            if ($user['hot_bean_nums'] < $nums) api_err("可用hot不足");

            $user->frozen_hot_bean_nums += $nums; // 冻结hot
            $user->save();
        }

        // 检查数量和金额类型是否一致
        OrderService::checkNumsWithType($nums, $order_amount_type);

        // 检查价格是否在前一日成交订单平均价格上下的10%(后端可配置)
        OrderService::checkPubPrice($price);

        // 设置交易密码后再放开
        $lock_status = HotPublishOrder::LOCK_STATUS_ON;

        return $user->publishOrder()->create(
            compact('price', 'nums', 'order_type', 'order_amount_type', 'lock_status')
        );
    }

    /**
     * 设置交易密码
     *
     * @param HotPublishOrder $publishOrder
     * @param                 $secret
     *
     * @return bool
     */
    public static function setSecret(HotPublishOrder $publishOrder, HotUser $user, $secret)
    {
        if ($user->id != $publishOrder->hot_user_id) api_err('必须是本人设置密码');

        $publishOrder->secret = $secret;
        $publishOrder->lock_status = HotPublishOrder::LOCK_STATUS_OFF;

        return $publishOrder->save();
    }

    /**
     * 锁单
     *
     * @param HotUser         $user
     * @param HotPublishOrder $hotPublishOrder
     * @param int             $nums
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function lockOrder(HotUser $user, HotPublishOrder $hotPublishOrder, $nums = 0)
    {
        if ($hotPublishOrder->order_amount_type > 1 && $nums > 0) api_err('只有小单才能拆分');

        $remainNums = $hotPublishOrder->nums - $hotPublishOrder->frozen_nums;
        $nums = !empty($nums) ? $nums : $remainNums;

        // 检测挂单状态
        if ($hotPublishOrder->lock_status == HotPublishOrder::LOCK_STATUS_ON) api_err('锁定状态挂单不能锁单');

        if ($hotPublishOrder->hot_user_id == $user->id) api_err('不能锁定自己发布的挂单');

        // 检测挂单数量是否足够
        if ($remainNums < $nums) api_err('剩余数量不足');

        OrderService::checkOpenTime();

        // 买单，当前用户是卖方
        if ($hotPublishOrder->order_type == HotPublishOrder::ORDER_TYPE_BUY) {
            if ($user->hot_bean_nums < $nums) api_err("可用hot不足");

            $user->frozen_hot_bean_nums += $nums; // 冻结hot
            $user->save();

            $hotUserId = $hotPublishOrder->hot_user_id;
            $sellerUserId = $user->id;
        }

        // 卖单，当前用户是买方
        if ($hotPublishOrder->order_type == HotPublishOrder::ORDER_TYPE_SALE) {
            OrderService::checkSellerCloseTime();

            $hotUserId = $user->id;
            $sellerUserId = $hotPublishOrder->hot_user_id;
        }

        $hotPublishOrder->frozen_nums += $nums;
        if ($remainNums - $nums == 0) {
            $hotPublishOrder->lock_status = HotPublishOrder::LOCK_STATUS_ON;
        }

        // 更新挂单
        $hotPublishOrder->save();

        // 创建订单
        return $hotPublishOrder->userOrders()->create([
            'order_no' => OrderService::getOrderNum(),
            'order_type' => $hotPublishOrder->order_type,
            'order_amount_type' => $hotPublishOrder->order_amount_type,
            'nums' => $nums,
            'price' => $hotPublishOrder->price,
            'amount' => round($hotPublishOrder->price * $nums, 2),
            'hot_user_id' => $hotUserId,
            'seller_user_id' => $sellerUserId,
            'lock_time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 取消订单(买方)
     *
     * @param HotUser      $user
     * @param HotUserOrder $userOrder
     *
     * @return HotUserOrder
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function cancelOrder(HotUser $user, HotUserOrder $userOrder)
    {
        if ($user->id != $userOrder->hot_user_id) api_err('不能取消非本人锁定的订单');

        $cancelTimes = cache('buyer_max_cancel_times_'.date('Ymd').$user->id) ?? 0;
        $maxCancelTimes = SettingService::getSetting('buyer_max_cancel_times');
        if ($cancelTimes + 1 > $maxCancelTimes) api_err('已超过每人最多取消订单次数：'.$maxCancelTimes);

        $publishOrder = HotPublishOrder::query()->where('id', $userOrder->publish_order_id)->first();
        if (empty($publishOrder)) api_err('数据错误，不存在对应挂单');

        $publishOrder->frozen_nums -= $userOrder->nums; // 冻结数回退
        if ($publishOrder->frozen_nums == 0) $publishOrder->lock_status = HotPublishOrder::LOCK_STATUS_OFF; // 挂单解锁
        $publishOrder->save();

        // 卖方冻结数回退
        $sellerUser = HotUser::find($userOrder->seller_user_id);
        if (empty($sellerUser)) api_err('卖方数据不存在');
        $sellerUser->frozen_hot_bean_nums -= $userOrder->nums;
        $sellerUser->save();

        // 取消订单
        $userOrder->order_status = HotUserOrder::ORDER_STATUS_CANCEL;
        $userOrder->save();

        // 取消次数+1
        $cancelTimes = cache('buyer_max_cancel_times_'.date('Ymd').$user->id, $cancelTimes + 1, 60 * 24);

        return $userOrder;
    }

    // 上传打款凭证(买方)
    public static function uploadPayAttach(HotUser $user)
    {

    }

    // 申诉(买方)
    public static function complain(HotUser $user, $content)
    {

    }

    // 确认付款(买方)
    public static function confirmPay(HotUser $user, HotUserOrder $userOrder)
    {
        if (empty($userOrder->pay_attach)) api_err('请先上传打款凭证');
        if ($userOrder->order_status >= HotUserOrder::ORDER_STATUS_PAYED) api_err("已确认付款，无需重复操作");

        $userOrder->order_status_buyer = HotUserOrder::ORDER_STATUS_BUYER_PAYED;
        $userOrder->save();

        return $userOrder;
    }

    /**
     * 确认收货(买方)
     *
     * @param HotUser      $user
     * @param HotUserOrder $userOrder
     *
     * @return HotUserOrder
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function confirmShip(HotUser $user, HotUserOrder $userOrder)
    {
        if ($user->id != $userOrder->hot_user_id) api_err('该订单不是本人的');
        if ($userOrder->order_status_seller != HotUserOrder::ORDER_STATUS_SELLER_HOT) api_err('卖方没有释放hot，不能确认收货');
        if ($userOrder->order_status_buyer == HotUserOrder::ORDER_STATUS_BUYER_CANCEL) api_err('买方已取消次订单');
        if ($userOrder->order_status_buyer == HotUserOrder::ORDER_STATUS_BUYER_SHIPED) api_err('买方已确认收货，无需重复操作');

        $userOrder->order_status_buyer = HotUserOrder::ORDER_STATUS_BUYER_SHIPED;
        $userOrder->save();

        return $userOrder;
    }

    /**
     * 确认收款(卖方)
     *
     * @param HotUser      $user
     * @param HotUserOrder $userOrder
     *
     * @return HotUserOrder
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function confirmPayed(HotUser $user, HotUserOrder $userOrder)
    {
        if ($user->id != $userOrder->seller_user_id) api_err('你不是卖方，不能确认收款');
        if ($userOrder->order_status_buyer < HotUserOrder::ORDER_STATUS_BUYER_PAYED) api_err('买方未确认付款，不能确认收款');

        $userOrder->order_status_seller = HotUserOrder::ORDER_STATUS_SELLER_PAYED;
        $userOrder->order_status = HotUserOrder::ORDER_STATUS_PAYED; // 更新订单状态
        $userOrder->save();

        return $userOrder;
    }

    // 释放hot(卖方)
    public static function giveHot(HotUser $user, HotUserOrder $userOrder)
    {
        if ($user->id != $userOrder->seller_user_id) api_err('您不是该订单的发布者，不能释放hot');
        if ($userOrder->order_status_seller == HotUserOrder::ORDER_STATUS_SELLER_HOT) api_err('已释放hot，无需重复操作');
        if ($userOrder->order_status_seller < HotUserOrder::ORDER_STATUS_SELLER_PAYED) api_err('请先确认收款');

        $userOrder->order_status_seller = HotUserOrder::ORDER_STATUS_SELLER_HOT; // 卖方状态变为释放hot
        $userOrder->save();

        // 卖方减hot，减冻结hot
        $user->frozen_hot_bean_nums -= $userOrder->nums;
        $user->hot_bean_nums -= $userOrder->nums;
        $user->save();

        // 买方得到hot
        $buyer = HotUser::find($userOrder->hot_user_id);
        if (empty($buyer)) api_err('买方不存在,数据异常');
        $buyer->frozen_hot_bean_nums += $userOrder->nums;
        $buyer->hot_bean_nums += $userOrder->nums;
        $buyer->save();

        // TODO 加入job到队列，让买方自动收货完成订单

        return $userOrder;
    }

}
