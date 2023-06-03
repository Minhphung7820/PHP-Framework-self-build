<?php

namespace Http\Middlewares;

use Supports\Http\Request;

class CheckLogin
{
    public function handle(Request $request, $sendRequest, $next)
    {
        if (1 + 1 === 2) {
            return $next($sendRequest);
        }
        return redirect('https://www.thegioididong.com/');
    }
}
