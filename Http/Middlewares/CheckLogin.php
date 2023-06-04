<?php

namespace Http\Middlewares;

use Closure;
use Supports\Http\Request;

class CheckLogin
{
    public function handle(Closure $next, Request $request, int $a = null, int $b = null)
    {
        if ($b + $a === 2) {
            return response()->json($request->NEXT_REQUEST);
        }
        return $next($request);
    }
}
