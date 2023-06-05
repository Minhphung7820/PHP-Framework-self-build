<?php

namespace Http\Middlewares;

use Closure;
use Supports\Http\Request;

class CheckLogin
{
    public function handle(Closure $next, Request $request, $a, $b)
    {
        if ($b + $a === 2) {
            return response()->json("CC");
        }
        return $next($request);
    }
}
