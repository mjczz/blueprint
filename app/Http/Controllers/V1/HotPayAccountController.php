<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotPayAccountStoreRequest;
use App\Http\Requests\HotPayAccountUpdateRequest;
use App\Http\Resources\HotPayAccountResource as HotPayAccountResource;
use App\Http\Resources\HotPayAccountCollection;
use App\Models\HotPayAccount;
use Illuminate\Http\Request;

class HotPayAccountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HotPayAccountCollection
     */
    public function index(Request $request)
    {
        $hotPayAccounts = HotPayAccount::all();

        return new HotPayAccountCollection($hotPayAccounts);
    }

    /**
     * @param \App\Http\Requests\HotPayAccountStoreRequest $request
     *
     * @return \App\Http\Resources\HotPayAccountResource
     */
    public function store(HotPayAccountStoreRequest $request)
    {
        $hotPayAccount = HotPayAccount::create($request->all());

        return new HotPayAccountResource($hotPayAccount);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotPayAccount $hotPayAccount
     *
     * @return \App\Http\Resources\HotPayAccountResource
     */
    public function show(Request $request, HotPayAccount $hotPayAccount)
    {
        return new HotPayAccountResource($hotPayAccount);
    }

    /**
     * @param \App\Http\Requests\HotPayAccountUpdateRequest $request
     * @param \App\Models\HotPayAccount $hotPayAccount
     *
     * @return \App\Http\Resources\HotPayAccountResource
     */
    public function update(HotPayAccountUpdateRequest $request, HotPayAccount $hotPayAccount)
    {
        $hotPayAccount->update([]);

        return new HotPayAccountResource($hotPayAccount);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotPayAccount $hotPayAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, HotPayAccount $hotPayAccount)
    {
        $hotPayAccount->delete();

        return response()->noContent(200);
    }
}
