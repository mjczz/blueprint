<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturn;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    use ApiReturn;

    protected $limit = 10;
}
