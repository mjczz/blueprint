<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DemoStoreRequest;
use App\Http\Requests\DemoUpdateRequest;
use App\Http\Resources\DemoResource;
use App\Models\Demo;
use App\Models\Demo2;
use Illuminate\Http\Request;
use function response;

class DemoController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $query = Demo::query();

        // 查询条件
        Demo::getWhere($query, $request);

        // 排序条件
        Demo::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(DemoResource::collection($paginator->items()), $paginator);
    }

    /**
     * @param \App\Http\Requests\NewsStoreRequest $request
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function store(DemoStoreRequest $request)
    {
        $demo = Demo::create($request->all());

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Demo $demo
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function show(Request $request, Demo $demo)
    {
        return $this->json(new DemoResource($demo));
    }

    /**
     * @param \App\Http\Requests\NewsUpdateRequest $request
     * @param \App\Models\Demo $demo
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function update(DemoUpdateRequest $request, Demo $demo)
    {
        $model->update($request->all());

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Demo $demo
     */
    public function destroy(Request $request, Demo $demo)
    {
        $demo->delete();

        return $this->sucess();
    }
}
