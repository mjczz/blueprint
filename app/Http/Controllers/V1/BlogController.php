<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // 查询条件
        Blog::getWhere($query, $request);

        // 排序条件
        Blog::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(BlogResource::collection($paginator->items()), $paginator);
    }

    /**
     * @param \App\Http\Requests\NewsStoreRequest $request
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function store(BlogStoreRequest $request)
    {
        $news = Blog::create($request->all());

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Blog $blog
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function show(Request $request, Blog $blog)
    {
        return $this->json(new BlogResource($blog));
    }

    /**
     * @param \App\Http\Requests\NewsUpdateRequest $request
     * @param \App\Models\Blog $blog
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function update(BlogUpdateRequest $request, Blog $blog)
    {
        $model->update($request->all());

        return $this->sucess();
    }
}
