<?php

namespace App\Http\Middleware;

use App\Services\ApiReturnService;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use function route;
use function strpos;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (strpos($request->route()->getPrefix(), 'v1') !== false) {
            return route("unAuth");
        }

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
