<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'publish_status',
        'news_top',
        'news_recommend',
        'news_type',
        'sort',
        'published_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'publish_status' => 'integer',
        'news_top' => 'integer',
        'news_recommend' => 'integer',
        'news_type' => 'integer',
        'sort' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // 修改状态值，为了方便查询使用$query->when()方法,传0不筛选
            if ($model->news_top == 0) $model->news_top = 2;
            if ($model->news_type == 0) $model->news_type = 2;
            if ($model->news_recommend == 0) $model->news_recommend = 2;
            if ($model->publish_status == 0) $model->publish_status = 2;
        });
    }

    /**
     * 查询条件
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param \Illuminate\Http\Request $request
     */
    public static function getWhere($query, $request)
    {
        $query->when($request['news_top'], function($query) use ($request){
            $query->where("news_top", $request['news_top']);
        });

        $query->when($request['news_type'], function($query) use ($request){
            $query->where("news_type", $request['news_type']);
        });

        $query->when($request['news_recommend'], function($query) use ($request){
            $query->where("news_recommend", $request['news_recommend']);
        });

        $query->when($request['publish_status'], function($query) use ($request){
            $query->where("publish_status", $request['publish_status']);
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
                $query->orderBy('id', 'asc');
                break;
            default:
                $query->orderBy('news_top', 'desc')->orderBy('id', 'desc');
                break;
        }
    }

}
