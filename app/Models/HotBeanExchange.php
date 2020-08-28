<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class HotBeanExchange extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hot_user_id',
        'exchange_type',
        'from_nums',
        'to_nums',
        'service_charge',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hot_user_id' => 'integer',
        'exchange_type' => 'integer',
        'from_nums' => 'integer',
        'to_nums' => 'integer',
        'service_charge' => 'decimal:2',
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
        $query->when($request['exchange_type'], function($query) use ($request){
            $query->where("exchange_type", $request['exchange_type']);
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
        return $this->belongsTo(\App\Models\HotUser::class);
    }
}
