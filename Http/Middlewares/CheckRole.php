<?php

namespace Http\Middlewares;

use Closure;

class CheckRole
{
    public function handle(Closure $next, $request)
    {
        if (10 - 7 === 6) {
            return redirect('https://fptshop.com.vn/');
        }
        return $next($request);
    }
}
