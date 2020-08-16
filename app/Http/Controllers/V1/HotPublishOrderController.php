<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\HotPublishOrderStoreRequest;
use App\Http\Requests\HotPublishOrderUpdateRequest;
use App\Http\Resources\HotPublishOrderResource;
use App\Models\HotPublishOrder;
use App\Services\Hot\UserBehaivor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotPublishOrderController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HotPublishOrderCollection
     */
    public function index(Request $request)
    {
        $query = HotPublishOrder::with('HotUser');

        // 查询条件
        HotPublishOrder::getWhere($query, $request);

        // 展示未锁定的挂单
        $query->where('lock_status', HotPublishOrder::LOCK_STATUS_OFF);

        // 排序条件
        HotPublishOrder::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(HotPublishOrderResource::collection($paginator->items()), $paginator);
    }

    /**
     * 锁单
     *
     * @param Request         $request
     * @param HotPublishOrder $hotPublishOrder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lockOrder(Request $request, HotPublishOrder $hotPublishOrder)
    {
        transaction(function() use ($hotPublishOrder, $request) {
            UserBehaivor::lockOrder(Auth::guard('hot')->user(), $hotPublishOrder, $request->nums ?? 0);
        });

        return $this->sucess();
    }

    /**
     * 发布订单
     *
     * @param \App\Http\Requests\HotPublishOrderStoreRequest $request
     *
     * @return \App\Http\Resources\HotPublishOrderResource
     */
    public function store(HotPublishOrderStoreRequest $request)
    {
        transaction(function() use ($request) {
            UserBehaivor::pubOrder(Auth::guard('hot')->user(), $request['price'], $request['nums'], $request['order_type'], $request['order_amount_type']);
        });

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotPublishOrder $hotPublishOrder
     *
     * @return \App\Http\Resources\HotPublishOrderResource
     */
    public function show(Request $request, HotPublishOrder $hotPublishOrder)
    {
        return $this->json(new HotPublishOrderResource($hotPublishOrder));
    }

    /**
     * 设置交易密码
     *
     * @param Request         $request
     * @param HotPublishOrder $hotPublishOrder
     *
     * @return \think\response\Json
     */
    public function update(Request $request, HotPublishOrder $hotPublishOrder)
    {
        $this->validate($request, [
            'secret' => 'required|string',
        ], [
            'secret.required' => '交易密码不能为空'
        ]);

        UserBehaivor::setSecret($hotPublishOrder, Auth::guard('hot')->user(), $request->secret);

        return $this->sucess();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotPublishOrder $hotPublishOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, HotPublishOrder $hotPublishOrder)
    {
        $hotPublishOrder->delete();

        return $this->sucess();
    }
}
