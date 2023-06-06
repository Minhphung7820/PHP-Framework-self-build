<?php

namespace Http\Middlewares;

use Closure;
use Models\ProductsModel;
use Repositories\Interfaces\InterfaceProductRepository;
use Supports\Http\Request;
use Supports\Facades\Logger;

class CheckLogin
{
    public function handle(ProductsModel $productsModel, InterfaceProductRepository $repoProd, Closure $next, Request $request, $a, $b)
    {
        if ($b + $a === 2) {
            // Logger::info('Chưa đăng nhập mà đòi vô !');
            return response()->json(['success' => false, "msg" => 'Unauthenticated'], 401);
        }
        return $next($request);
    }
}
