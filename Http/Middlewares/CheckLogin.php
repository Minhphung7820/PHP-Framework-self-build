<?php

namespace Http\Middlewares;

use Http\Middlewares\BaseMiddleware;

class CheckLogin extends BaseMiddleware
{
    public function handle($request, $next)
    {
        if (1 + 1 === 2) {
            return $next($request);
        }
        return redirect('https://www.thegioididong.com/');
    }
}
