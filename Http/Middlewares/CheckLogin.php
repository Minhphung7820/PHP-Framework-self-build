<?php

namespace Http\Middlewares;

use Closure;
use Models\ProductsModel;
use Repositories\Interfaces\InterfaceProductRepository;
use Supports\Http\Request;

class CheckLogin
{
    public function handle(ProductsModel $productsModel, InterfaceProductRepository $repoProd, Closure $next, Request $request, $a, $b)
    {
        if ($b + $a === 2) {
            return response()->json(['success' => false, "msg" => 'Chưa đăng nhập mà đòi vô']);
        }
        return $next($request);
    }
}
