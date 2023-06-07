<?php

namespace App\Http\Middlewares\Auth;

use Closure;
use Supports\Facades\Logger;
use Supports\Http\Request;

class JWTvalid
{
    public function handle(Request $request, Closure $next)
    {
        $msg = '';
        if (auth()->check()) {
            $authorizationHeader = $request->header('Authorization');
            if (strpos($authorizationHeader, 'Bearer') === 0) {
                $token = substr($authorizationHeader, 7);
                $checkValidJWT = auth()->validJWT($token);
                if ($checkValidJWT) {
                    return $next($request);
                } else {
                    $msg = 'Unauthorized';
                    Logger::error("Token không hợp lệ hoặc hết hạn !");
                }
            } else {
                $msg = 'Unauthorized';
                Logger::error("Token không có !");
            }
        } else {
            $msg = 'Unauthenticated';
            Logger::error("Chưa đăng nhập !");
        }
        return response()->json(['success' => false, "message" =>  $msg], 401);
    }
}
