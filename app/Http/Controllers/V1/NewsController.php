<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsStoreRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends ApiBaseController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param NewsStoreRequest $request
     *
     * @return \think\response\Json
     */
    public function store(NewsStoreRequest $request)
    {
        $news = News::create($request->all());

        return $this->sucess();
    }

    /**
     * @param Request $request
     * @param News    $news
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, News $news)
    {
        return $this->json(new NewsResource($news));
    }

    /**
     * @param NewsUpdateRequest $request
     * @param News              $news
     *
     * @return \think\response\Json
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        $news->update($request->all());

        return $this->sucess();
    }

    /**
     * @param Request $request
     * @param News    $news
     *
     * @return \think\response\Json
     * @throws \Exception
     */
    public function destroy(Request $request, News $news)
    {
        $news->delete();

        return $this->sucess();
    }
}
