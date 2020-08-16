<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotUserStoreRequest;
use App\Http\Requests\HotUserUpdateRequest;
use App\Http\Resources\HotUserResource as HotUserResource;
use App\Http\Resources\HotUserCollection;
use App\Models\HotUser;
use Illuminate\Http\Request;

class HotUserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HotUserCollection
     */
    public function index(Request $request)
    {
        $hotUsers = HotUser::all();

        return new HotUserCollection($hotUsers);
    }

    /**
     * @param \App\Http\Requests\HotUserStoreRequest $request
     *
     * @return \App\Http\Resources\HotUserResource
     */
    public function store(HotUserStoreRequest $request)
    {
        $hotUser = HotUser::create($request->all());

        return new HotUserResource($hotUser);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotUser $hotUser
     *
     * @return \App\Http\Resources\HotUserResource
     */
    public function show(Request $request, HotUser $hotUser)
    {
        return new HotUserResource($hotUser);
    }

    /**
     * @param \App\Http\Requests\HotUserUpdateRequest $request
     * @param \App\Models\HotUser $hotUser
     *
     * @return \App\Http\Resources\HotUserResource
     */
    public function update(HotUserUpdateRequest $request, HotUser $hotUser)
    {
        $hotUser->update([]);

        return new HotUserResource($hotUser);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HotUser $hotUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, HotUser $hotUser)
    {
        $hotUser->delete();

        return response()->noContent(200);
    }
}
