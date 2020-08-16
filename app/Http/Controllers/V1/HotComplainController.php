<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotComplainStoreRequest;
use App\Http\Requests\HotComplainUpdateRequest;
use App\Http\Resources\HotComplainResource as HotComplainResource;
use App\Http\Resources\HotComplainCollection;
use App\Models\HotComplain;
use Illuminate\Http\Request;

class HotComplainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HotComplainCollection
     */
    public function index(Request $request)
    {
        $hotComplains = HotComplain::all();

        return new HotComplainCollection($hotComplains);
    }

    /**
     * @param \App\Http\Requests\HotComplainStoreRequest $request
     *
     * @return \App\Http\Resources\HotComplainResource
     */
    public function store(HotComplainStoreRequest $request)
    {
        $hotComplain = HotComplain::create($request->all());

        return new HotComplainResource($hotComplain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotComplain $hotComplain
     *
     * @return \App\Http\Resources\HotComplainResource
     */
    public function show(Request $request, HotComplain $hotComplain)
    {
        return new HotComplainResource($hotComplain);
    }

    /**
     * @param \App\Http\Requests\HotComplainUpdateRequest $request
     * @param \App\Models\HotComplain $hotComplain
     *
     * @return \App\Http\Resources\HotComplainResource
     */
    public function update(HotComplainUpdateRequest $request, HotComplain $hotComplain)
    {
        $hotComplain->update([]);

        return new HotComplainResource($hotComplain);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotComplain $hotComplain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, HotComplain $hotComplain)
    {
        $hotComplain->delete();

        return response()->noContent(200);
    }
}
