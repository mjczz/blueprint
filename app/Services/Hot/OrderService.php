<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/8/15
 * Time: 22:54
 */

namespace App\Services\Hot;

use App\Models\HotUserOrder;
use App\Services\SettingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public static function getOrderNum()
    {
        $input = date("Ymd").time().random_int(1, 999);

        return str_pad($input, 6, '0');
    }

    // 检查买单卖单开始关闭时间
    public static function checkOpenTime()
    {

    }

    // 检查发布卖单关闭时间
    public static function checkSellerCloseTime()
    {

    }

    // 每日单价
    public static function avgPrice($date = 'yesterday')
    {
        return 10;
    }

    // 昨日平均单价
    public static function yesterdayAvgPrice()
    {
        return 10;
    }

    /**
     * 检查发布挂单的价格
     *
     * @param $price
     *
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function checkPubPrice($price)
    {
        $avgPriceRate = SettingService::getSetting('avg_price_rate');
        $minRate = 1 - $avgPriceRate / 100;
        $maxRate = 1 + $avgPriceRate / 100;
        $avgPrice = self::yesterdayAvgPrice();

        $min = $avgPrice * $minRate;
        if ($price < $min) api_err('发布价格小于昨日平均单价的'.$avgPriceRate.'%');

        $max = $avgPrice * $maxRate;
        if ($price > $max) api_err('发布价格大于昨日平均单价的'.$avgPriceRate.'%');
    }

    /**
     * 检查发布数量和金额类型是否对等
     *
     * @param $nums
     * @param $orderAmountType
     *
     * @throws \App\Exceptions\ApiCommonException
     */
    public static function checkNumsWithType($nums, $orderAmountType)
    {
        $types = SettingService::getSetting('order_amount_type');
        $type = $types[$orderAmountType] ?? 0;
        if (empty($type)) api_err('未找到匹配的金额类型');

        $arr = explode('-', $type);
        if (!is_array($arr)) api_err('未设置金额类型');

        if ($nums < $arr[0]) api_err('发布数量不能小于'.$arr[0]);
        if ($nums > $arr[1]) api_err('发布数量不能大于'.$arr[1]);
    }

    // 自动确认收款
    public static function autoConfirmPayed()
    {

    }

    // 自动释放hot
    public static function autoGiveHot()
    {

    }

    // 自动确认收货
    public static function autuConfirmShip()
    {

    }

    // 每日成交统计
    public static function dayTotal()
    {
        $start = Carbon::yesterday()->toDateString();
        $end = Carbon::today()->toDateString();

        $res = HotUserOrder::query()
            ->where('order_status', HotUserOrder::ORDER_STATUS_COMPLETE)
            ->whereBetween('complete_time', [$start, $end])
            ->select();

        $totalAmount = $res->sum('amount');
        $totalSum = $res->sum('nums');

        $data = [
            'ymd' => date('Ymd', strtotime($start)),
            'total_amount' => $totalAmount,
            'total_sum' => $totalSum,
            'avg_price' => !empty($totalAmount) && !empty($totalSum) ? round($totalAmount / $totalSum, 2) : 0,
        ];

        cache('day_total_'.$data['ymd'], json_encode($data));

        return $data;
    }

    // 释放冻结hot
    public static function releaseFrozenHot()
    {
        // 查所有订单
        HotUserOrder::query();

    }
}
