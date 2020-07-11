<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'title',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'status' => 'integer',
    ];


    public function comments()
    {
        return $this->morphMany(\App\Models\Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphMany(\App\Models\Tag::class, 'tagable');
    }

    public function image()
    {
        return $this->morphOne(\App\Models\Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

}
