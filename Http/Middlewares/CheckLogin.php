<?php

namespace Http\Middlewares;

class CheckLogin
{
    public function handle($sendRequest, $next)
    {
        if (1 + 1 === 2) {
            return $next($sendRequest);
        }
        return redirect('https://www.thegioididong.com/');
    }
}
