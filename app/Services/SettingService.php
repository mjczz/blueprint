<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/8/15
 * Time: 13:10
 */

namespace App\Services;

use function array_merge;

class SettingService
{
    /**
     * 获取后台设置
     *
     * @param null $key
     *
     * @return array|mixed
     */
    public static function getSetting($key = null)
    {
        // 时间参数设置
        $timeSettings = [
            // 交易所开发时间，置换中心开放时间9:00-22:00，2，21点卖单发布通道关闭；（前期测试阶段开放时间为10--17点）（后端配置）
            'opening_hours' => [
                'open' => '9:00',
                'close' => '22:00',
                'sale_close_hour' => '21:00',
            ],
            // hot冻结交易时间
            'hot_cloes' => [

            ],
            // 确认付款时间
            'confirm_pay' => 30,
            // 确认收款时间
            'confirm_payed' => 30,
            // 释放hot时间
            'give_hot' => 30,
            // 锁单时间
            'lock_time' => 30,
            // 重复锁单时间
            'repeat_lock_time' => 30,
            // 确认收货时间
        ];

        // 金额参数设置
        $moneySettings = [
            // 买卖最低交易数量
            'low_nums' => 1,
            // 买卖最高交易数量
            'max_nums' => 1000,
            // 卖方每天最高交易数量
            'seller_max_trade_nums' => 300,
            // 卖方每天最高交易次数
            'seller_max_trade_times' => 3,
            // 买方每天最高可取消次数：
            'buyer_max_cancel_times' => 3,
            // 发布订单，价格在平均价格上下的10%
            'avg_price_rate' => 10,
        ];

        // 系统参数设置
        $sysSettings = [
            // 闭市清空订单，是否，默认是
            'close_clear_orders' => 1,
            // 默认1--10为散单，（11-100）为中单，101--1000为大单
            'order_amount_type' => [
                '1' => '1-10', // 小单
                '2' => '11-100', // 中单
                '3' => '101-1000', // 大单
            ]
        ];

        // 限额参数设置
        $limit = [
            // 普通用户限额
            'normal' => 1,
            // 红人用户限额
            'red' => 100,
            // 达人用户限额
            'expert' => 200,
            // 明星用户限额
            'star' => 300,
            // 战神用户限额
            'god' => 400,
        ];

        // 后台配置
        $settings = array_merge($timeSettings, $moneySettings, $sysSettings, $limit);

        if (isset($key)) return !empty($settings[$key]) ? $settings[$key] : [];

        return $settings;
    }

}
