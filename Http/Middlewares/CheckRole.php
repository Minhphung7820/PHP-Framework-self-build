<?php

namespace Http\Middlewares;

class CheckRole
{
    public function handle($sendRequest, $next)
    {
        if (10 - 7 === 6) {
            return redirect('https://fptshop.com.vn/');
        }
        return $next($sendRequest);
    }
}
