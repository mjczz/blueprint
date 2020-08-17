<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class HotPayAccount extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_type',
        'account',
        'account_name',
        'hot_user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'account_type' => 'integer',
        'hot_user_id' => 'integer',
        'created_at' => 'datetime Y-m-d H:i:s',
        'updated_at' => 'datetime Y-m-d H:i:s',
    ];


    public function hotUser()
    {
        return $this->belongsTo(\App\Models\HotUser::class);
    }
}
