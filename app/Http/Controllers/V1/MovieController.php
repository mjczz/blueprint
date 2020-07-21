<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $query = Movie::query();

        // 查询条件
        Movie::getWhere($query, $request);

        // 排序条件
        Movie::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(MovieResource::collection($paginator->items()), $paginator);
    }

    /**
     * @param \App\Http\Requests\NewsStoreRequest $request
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function store(MovieStoreRequest $request)
    {
        $movie = Movie::create($request->all());

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function show(Request $request, Movie $movie)
    {
        return $this->json(new MovieResource($movie));
    }

    /**
     * @param \App\Http\Requests\NewsUpdateRequest $request
     * @param \App\Models\Movie $movie
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function update(MovieUpdateRequest $request, Movie $movie)
    {
        $model->update($request->all());

        return $this->sucess();
    }
}
