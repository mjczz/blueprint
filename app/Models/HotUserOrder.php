<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class HotUserOrder extends BaseModel
{
    use SoftDeletes;

    /**
     * 订单状态1已锁单2已取消3已付款4已完成5已关闭
     */
    const ORDER_STATUS_LOCK = 1;
    const ORDER_STATUS_CANCEL = 2;
    const ORDER_STATUS_PAYED = 3;
    const ORDER_STATUS_COMPLETE = 4;
    const ORDER_STATUS_CLOSE = 5;

    /**
     * 买方订单状态
     * '1' => '已锁单',
     * '2' => '确认付款',
     * '3' => '确认收货',
     * '4' => '已取消',
     */
    const ORDER_STATUS_BUYER_LOCK = 1;
    const ORDER_STATUS_BUYER_PAYED= 2;
    const ORDER_STATUS_BUYER_SHIPED = 3;
    const ORDER_STATUS_BUYER_CANCEL = 4;

    /**
     * 卖方订单状态
     * '1' => '已锁单',
     * '2' => '确认收款',
     * '3' => '释放hot',
     */
    const ORDER_STATUS_SELLER_LOCK = 1;
    const ORDER_STATUS_SELLER_PAYED = 2;
    const ORDER_STATUS_SELLER_HOT = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'publish_order_id',
        'order_no',
        'order_type',
        'order_status',
        'order_status_buyer',
        'order_status_seller',
        'order_amount_type',
        'nums',
        'price',
        'amount',
        'hot_user_id',
        'seller_user_id',
        'lock_time',
        'pay_time',
        'confirm_time',
        'pay_attach',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'publish_order_id' => 'integer',
        'order_type' => 'integer',
        'order_status' => 'integer',
        'order_amount_type' => 'integer',
        'nums' => 'integer',
        'price' => 'decimal:2',
        'amount' => 'decimal:2',
        'hot_user_id' => 'integer',
        'seller_user_id' => 'integer',
        'created_at' => 'datetime Y-m-d H:i:s',
        'updated_at' => 'datetime Y-m-d H:i:s',
        'lock_time' => 'datetime Y-m-d H:i:s',
        'pay_time' => 'datetime Y-m-d H:i:s',
        'confirm_time' => 'datetime Y-m-d H:i:s',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'lock_time',
        'pay_time',
        'confirm_time',
    ];

    /**
     * 查询条件
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param \Illuminate\Http\Request $request
     */
    public static function getWhere($query, $request)
    {
        $query->when($request['order_status'], function($query) use ($request){
            $query->where("order_status", $request['order_status']);
        });

        $query->when($request['order_type'], function($query) use ($request){
            $query->where("order_type", $request['order_type']);
        });

        $query->when($request['order_amount_type'], function($query) use ($request){
            $query->where("order_amount_type", $request['order_amount_type']);
        });

        $query->when($request['order_no'], function($query) use ($request){
            $query->where("order_no", 'like', '%'.$request['order_no'].'%');
        });
    }

    /**
     * 排序条件
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param \Illuminate\Http\Request $request
     */
    public static function orderBy($query, $request)
    {
        switch($request['order_by'] ?? 0) {
            case 1:
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }
    }

    public function complain()
    {
        return $this->hasOne(\App\Models\HotComplain::class);
    }

    public function publishOrder()
    {
        return $this->belongsTo(\App\Models\HotPublishOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\HotUser::class);
    }
}
