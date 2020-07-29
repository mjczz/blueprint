<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demo extends BaseModel
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
        'demo_top',
        'demo_recommend',
        'sort',
        'published_at',
        'demo_score',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'publish_status' => 'integer',
        'demo_top' => 'integer',
        'demo_recommend' => 'integer',
        'sort' => 'integer',
        'demo_score' => 'decimal:1',
        'created_at' => 'datetime Y-m-d H:i:s',
        'updated_at' => 'datetime Y-m-d H:i:s',
        'published_at' => 'datetime Y-m-d H:i:s'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // 修改状态值，为了方便查询使用$query->when()方法,传0不筛选
            if ($model->demo_top == 0) $model->demo_top = 2;
            if ($model->demo_recommend == 0) $model->demo_recommend = 2;
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
        $query->when($request['demo_top'], function($query) use ($request){
            $query->where("demo_top", $request['demo_top']);
        });

        $query->when($request['demo_recommend'], function($query) use ($request){
            $query->where("demo_recommend", $request['demo_recommend']);
        });

        $query->when($request['publish_status'], function($query) use ($request){
            $query->where("publish_status", $request['publish_status']);
        });

        // 筛选关联表的字段
        $query->when($request['user_name'], function($query) use ($request){
            $query->whereHas('user', function($query) use ($request){
                $query->where("name", "like", "%{$request['user_name']}%");
            });
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
                $query->orderBy('demo_top', 'desc')->orderBy('id', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
                break;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
