<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'keywords',
        'desc',
        'copyright',
        'icp',
        'external_traffic',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}