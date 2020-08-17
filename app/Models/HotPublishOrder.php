<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class HotPublishOrder extends BaseModel
{
    use SoftDeletes;

    const ORDER_TYPE_BUY = 1;
    const ORDER_TYPE_SALE = 2;

    const LOCK_STATUS_OFF = 1;
    const LOCK_STATUS_ON = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lock_status',
        'order_type',
        'order_amount_type',
        'nums',
        'frozen_nums',
        'price',
        'hot_user_id',
        'sales_service_charge',
        'secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'lock_status' => 'integer',
        'order_type' => 'integer',
        'order_amount_type' => 'integer',
        'nums' => 'integer',
        'frozen_nums' => 'decimal:2',
        'price' => 'decimal:2',
        'hot_user_id' => 'integer',
        'sales_service_charge' => 'decimal:2',
        'created_at' => 'datetime Y-m-d H:i:s',
        'updated_at' => 'datetime Y-m-d H:i:s',
    ];

    /**
     * 查询条件
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param \Illuminate\Http\Request $request
     */
    public static function getWhere($query, $request)
    {
        $query->when($request['lock_status'], function($query) use ($request){
            $query->where("lock_status", $request['lock_status']);
        });

        $query->when($request['order_type'], function($query) use ($request){
            $query->where("order_type", $request['order_type']);
        });

        $query->when($request['order_amount_type'], function($query) use ($request){
            $query->where("order_amount_type", $request['order_amount_type']);
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

    public function hotUser()
    {
        return $this->belongsTo(\App\Models\HotUser::class, 'hot_user_id', 'id');
    }

    public function userOrders()
    {
        return $this->hasMany(\App\Models\HotUserOrder::class, 'publish_order_id', 'id');
    }
}
