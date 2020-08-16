<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotBeanExchangeStoreRequest;
use App\Http\Requests\HotBeanExchangeUpdateRequest;
use App\Http\Resources\HotBeanExchange as HotBeanExchangeResource;
use App\Http\Resources\HotBeanExchangeCollection;
use App\Models\HotBeanExchange;
use Illuminate\Http\Request;

class HotBeanExchangeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HotBeanExchangeCollection
     */
    public function index(Request $request)
    {
        $hotBeanExchanges = HotBeanExchange::all();

        return new HotBeanExchangeCollection($hotBeanExchanges);
    }

    /**
     * @param \App\Http\Requests\HotBeanExchangeStoreRequest $request
     * @return \App\Http\Resources\HotBeanExchange
     */
    public function store(HotBeanExchangeStoreRequest $request)
    {
        $hotBeanExchange = HotBeanExchange::create($request->all());

        return new HotBeanExchangeResource($hotBeanExchange);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotBeanExchange $hotBeanExchange
     * @return \App\Http\Resources\HotBeanExchange
     */
    public function show(Request $request, HotBeanExchange $hotBeanExchange)
    {
        return new HotBeanExchangeResource($hotBeanExchange);
    }

    /**
     * @param \App\Http\Requests\HotBeanExchangeUpdateRequest $request
     * @param \App\Models\HotBeanExchange $hotBeanExchange
     * @return \App\Http\Resources\HotBeanExchange
     */
    public function update(HotBeanExchangeUpdateRequest $request, HotBeanExchange $hotBeanExchange)
    {
        $hotBeanExchange->update([]);

        return new HotBeanExchangeResource($hotBeanExchange);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotBeanExchange $hotBeanExchange
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, HotBeanExchange $hotBeanExchange)
    {
        $hotBeanExchange->delete();

        return response()->noContent(200);
    }
}
