<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HotUser extends Authenticatable
{
    use SoftDeletes,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'mobile',
        'app_user_id',
        'red_bean_nums',
        'hot_bean_nums',
        'frozen_hot_bean_nums',
        'hot_user_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'app_user_id' => 'integer',
        'red_bean_nums' => 'integer',
        'hot_bean_nums' => 'integer',
        'frozen_hot_bean_nums' => 'integer',
        'hot_user_status' => 'integer',
        'created_at' => 'datetime Y-m-d H:i:s',
        'updated_at' => 'datetime Y-m-d H:i:s',
    ];

    /**
     * 为数组/ JSON序列化准备一个日期。
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function userOrders()
    {
        return $this->hasMany(\App\Models\HotUserOrder::class);
    }

    public function publishOrder()
    {
        return $this->hasMany(\App\Models\HotPublishOrder::class);
    }

    public function complains()
    {
        return $this->hasMany(\App\Models\HotComplain::class);
    }

    public function beanExchanges()
    {
        return $this->hasMany(\App\Models\HotBeanExchange::class);
    }

    public function payAccounts()
    {
        return $this->hasMany(\App\Models\HotPayAccount::class);
    }
}
