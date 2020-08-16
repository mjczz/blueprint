<?php

namespace App\Http\Controllers\V1;

use App\Services\CommonService;
use Illuminate\Http\Request;

class CommonController extends ApiBaseController
{
    public function options(Request $request)
    {
        return $this->json(
            CommonService::getOptions($request->option_key)
        );
    }
}
