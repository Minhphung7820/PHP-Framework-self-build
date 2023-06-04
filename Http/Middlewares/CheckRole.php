<?php

namespace Http\Middlewares;

use Closure;
use Supports\Http\Request;

class CheckRole
{
    public function handle(Closure $next, Request $request, $a = null)
    {
        if (10 - $a === 6) {
            return response()->json("KK");
        }
        return $next($request);
    }
}
