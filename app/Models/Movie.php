<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'desc',
        'publish_status',
        'movie_top',
        'movie_recommend',
        'movie_hot',
        'sort',
        'published_at',
        'view_num',
        'score',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'publish_status' => 'integer',
        'movie_top' => 'integer',
        'movie_recommend' => 'integer',
        'movie_hot' => 'integer',
        'sort' => 'integer',
        'view_num' => 'integer',
        'score' => 'decimal:1',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * 查询条件
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param \Illuminate\Http\Request $request
     */
    public static function getWhere($query, $request)
    {
        $query->when($request['movie_top'], function($query) use ($request){
            $query->where("movie_top", $request['movie_top']);
        });

        $query->when($request['movie_recommend'], function($query) use ($request){
            $query->where("movie_recommend", $request['movie_recommend']);
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
                $query->orderBy('movie_top', 'desc')->orderBy('id', 'desc');
                break;
        }
    }

}
