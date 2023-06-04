<?php

namespace Http\Middlewares;

use Closure;

class CheckLogin
{
    public function handle(Closure $next, $request)
    {
        if (1 + 1 === 2) {
            return response()->json("CC");
        }
        return $next($request);
    }
}
