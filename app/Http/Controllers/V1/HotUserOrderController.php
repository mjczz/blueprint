<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotUserOrderStoreRequest;
use App\Http\Requests\HotUserOrderUpdateRequest;
use App\Http\Resources\HotUserOrderResource;
use App\Models\HotUserOrder;
use App\Services\Hot\UserBehaivor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotUserOrderController extends ApiBaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HotUserOrderCollection
     */
    public function index(Request $request)
    {
        $query = HotUserOrder::query();

        HotUserOrder::getWhere($query, $request);

        HotUserOrder::orderBy($query, $request);

        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator
         */
        $paginator = $query->paginate($request['limit'] ?? $this->limit);

        return $this->paginate(HotUserOrderResource::collection($paginator->items()), $paginator);
    }

    /**
     * 确认付款(买方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function confirmPay(Request $request, HotUserOrder $hotUserOrder)
    {
        transaction(function () use ($hotUserOrder) {
            UserBehaivor::confirmPay(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * 取消订单(买方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function cancelOrder(Request $request, HotUserOrder $hotUserOrder)
    {
        $this->validate($request, [
            'secret' => 'required|string',
        ], [
            'secret.required' => '交易密码不能为空'
        ]);

        transaction(function () use ($hotUserOrder) {
            UserBehaivor::cancelOrder(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * 上传打款凭证(买方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function uploadPayAttach(Request $request, HotUserOrder $hotUserOrder)
    {
        $this->validate($request, [
            'secret' => 'required|string',
        ], [
            'secret.required' => '交易密码不能为空'
        ]);

        transaction(function () use ($hotUserOrder) {
            UserBehaivor::uploadPayAttach(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * 申诉(买方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function complain(Request $request, HotUserOrder $hotUserOrder)
    {
        $this->validate($request, [
            'secret' => 'required|string',
        ], [
            'secret.required' => '交易密码不能为空'
        ]);

        transaction(function () use ($hotUserOrder) {
            UserBehaivor::complain(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * 确认收款(卖方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function confirmPayed(Request $request, HotUserOrder $hotUserOrder)
    {
        $this->validate($request, [
            'secret' => 'required|string',
        ], [
            'secret.required' => '交易密码不能为空'
        ]);

        transaction(function () use ($hotUserOrder) {
            UserBehaivor::confirmPayed(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * 确认收货(买方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function confirmShip(Request $request, HotUserOrder $hotUserOrder)
    {
        $this->validate($request, [
            'secret' => 'required|string',
        ], [
            'secret.required' => '交易密码不能为空'
        ]);

        transaction(function () use ($hotUserOrder) {
            UserBehaivor::confirmShip(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * 释放hot(卖方)
     *
     * @param Request      $request
     * @param HotUserOrder $hotUserOrder
     *
     * @return \think\response\Json
     * @throws \Throwable
     */
    public function giveHot(Request $request, HotUserOrder $hotUserOrder)
    {
        transaction(function () use ($hotUserOrder) {
            UserBehaivor::giveHot(Auth::guard('hot')->user(), $hotUserOrder);
        });

        return $this->sucess();
    }

    /**
     * @param \App\Http\Requests\HotUserOrderStoreRequest $request
     *
     * @return \App\Http\Resources\HotUserOrderResource
     */
    public function store(HotUserOrderStoreRequest $request)
    {
        $hotUserOrder = HotUserOrder::create($request->all());

        return new HotUserOrderResource($hotUserOrder);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotUserOrder $hotUserOrder
     *
     * @return \App\Http\Resources\HotUserOrderResource
     */
    public function show(Request $request, HotUserOrder $hotUserOrder)
    {
        return $this->json(new HotUserOrderResource($hotUserOrder));
    }

    /**
     * @param \App\Http\Requests\HotUserOrderUpdateRequest $request
     * @param \App\Models\HotUserOrder $hotUserOrder
     *
     * @return \App\Http\Resources\HotUserOrderResource
     */
    public function update(HotUserOrderUpdateRequest $request, HotUserOrder $hotUserOrder)
    {
        $hotUserOrder->update([]);

        return new HotUserOrderResource($hotUserOrder);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotUserOrder $hotUserOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, HotUserOrder $hotUserOrder)
    {
        $hotUserOrder->delete();

        return response()->noContent(200);
    }
}
