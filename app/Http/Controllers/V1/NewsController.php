<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsStoreRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Http\Resources\News as NewsResource;
use App\Http\Resources\NewsCollection;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\NewsCollection
     */
    public function index(Request $request)
    {
        $query = News::query();

        // 查询条件
        News::getWhere($query, $request);

        // 排序条件
        News::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(NewsResource::collection($paginator->items()), $paginator);
    }

    /**
     * @param \App\Http\Requests\NewsStoreRequest $request
     * @return \App\Http\Resources\News
     */
    public function store(NewsStoreRequest $request)
    {
        $news = News::create($request->all());

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\News $news
     * @return \App\Http\Resources\News
     */
    public function show(Request $request, News $news)
    {
        return $this->json(new NewsResource($news));
    }

    /**
     * @param \App\Http\Requests\NewsUpdateRequest $request
     * @param \App\Models\News $news
     * @return \App\Http\Resources\News
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        $news->update([]);

        return $this->sucess();
    }
}
