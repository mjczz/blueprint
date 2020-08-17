<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class HotComplain extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hot_user_id',
        'order_id',
        'complain_type',
        'complain_status',
        'content',
        'content_pic',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hot_user_id' => 'integer',
        'order_id' => 'integer',
        'complain_type' => 'integer',
        'complain_status' => 'integer',
        'created_at' => 'datetime Y-m-d H:i:s',
        'updated_at' => 'datetime Y-m-d H:i:s',
    ];


    public function hotUser()
    {
        return $this->belongsTo(\App\Models\HotUser::class);
    }

    public function hotUserOrder()
    {
        return $this->belongsTo(\App\Models\HotUserOrder::class);
    }
}
