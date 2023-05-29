<?php

namespace Http\Middlewares;

class CheckRole extends BaseMiddleware
{
    public function handle($request, $next)
    {
        if (10 - 5 === 6) {
            return redirect('https://fptshop.com.vn/');
        }
        return $next($request);
    }
}
