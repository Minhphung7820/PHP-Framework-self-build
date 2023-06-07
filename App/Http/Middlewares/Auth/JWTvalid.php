<?php

namespace App\Http\Middlewares\Auth;

use Closure;
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
                    $data = (array)$checkValidJWT;
                    if (time() > $data['exp']) {
                        $msg = 'Token expired';
                    } else {
                        return $next($request);
                    }
                } else {
                    $msg = 'Unauthorized';
                }
            } else {
                $msg = 'Unauthorized';
            }
        } else {
            $msg = 'Unauthenticated';
        }
        return response()->json(['success' => false, "message" =>  $msg], 401);
    }
}
