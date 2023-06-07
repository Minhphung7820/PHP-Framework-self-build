<?php

namespace App\Http\Middlewares;

use Closure;
use App\Models\ProductsModel;
use App\Repositories\Interfaces\InterfaceProductRepository;
use Supports\Facades\Auth;
use Supports\Http\Request;
use Supports\Facades\Logger;

class CheckLogin
{
    public function handle(Auth $auth, Closure $next, Request $request)
    {
        if (!$auth->check()) {
            return response()->json(['success' => false, "msg" => 'Unauthenticated'], 401);
        }
        return $next($request);
    }
}
