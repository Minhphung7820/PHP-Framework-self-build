<?php

namespace Http\Middlewares;

use Closure;
use Supports\Http\Request;

class CheckRole
{
    public function handle(Closure $next, Request $request, $a)
    {
        if (10 - $a === 6) {
            return response()->json(['success' => false, 'msg' => 'Bạn không đủ quyền truy cập !']);
        }
        return $next($request);
    }
}
