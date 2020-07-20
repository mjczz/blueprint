<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StubStoreRequest;
use App\Http\Requests\StubUpdateRequest;
use App\Http\Resources\StubResource;
use App\Models\Stub;
use Illuminate\Http\Request;

class StubController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $query = Stub::query();

        // 查询条件
        Stub::getWhere($query, $request);

        // 排序条件
        Stub::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(StubResource::collection($paginator->items()), $paginator);
    }

    /**
     * @param \App\Http\Requests\NewsStoreRequest $request
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function store(StubStoreRequest $request)
    {
        $news = Stub::create($request->all());

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stub $stub
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function show(Request $request, Stub $stub)
    {
        return $this->json(new StubResource($stub));
    }

    /**
     * @param \App\Http\Requests\NewsUpdateRequest $request
     * @param \App\Models\Stub $stub
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function update(StubUpdateRequest $request, Stub $stub)
    {
        $model->update($request->all());

        return $this->sucess();
    }
}
