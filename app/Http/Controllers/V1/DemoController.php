<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DemoStoreRequest;
use App\Http\Requests\DemoUpdateRequest;
use App\Http\Resources\DemoResource;
use App\Http\Resources\DemoUserResource;
use App\Models\Demo;
use Illuminate\Http\Request;

class DemoController extends ApiBaseController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * 关联表查询
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listData(Request $request)
    {
        $query = Demo::with('user');

        // 查询条件
        Demo::getWhere($query, $request);

        // 排序条件
        Demo::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(DemoUserResource::collection($paginator->items()), $paginator);
    }

    /**
     * @param DemoStoreRequest $request
     *
     * @return \think\response\Json
     */
    public function store(DemoStoreRequest $request)
    {
        $demo = Demo::create($request->all());

        return $this->sucess();
    }

    /**
     * @param Request $request
     * @param Demo    $demo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Demo $demo)
    {
        return $this->json(new DemoResource($demo));
    }

    /**
     * @param DemoUpdateRequest $request
     * @param Demo              $demo
     *
     * @return \think\response\Json
     */
    public function update(DemoUpdateRequest $request, Demo $demo)
    {
        $model->update($request->all());

        return $this->sucess();
    }

    /**
     * @param Request $request
     * @param Demo    $demo
     *
     * @return \think\response\Json
     * @throws \Exception
     */
    public function destroy(Request $request, Demo $demo)
    {
        $demo->delete();

        return $this->sucess();
    }
}
