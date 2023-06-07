<?php

namespace Supports\Facades;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    const JWT_SECRECT_KEY = 'fded5c1ce6529df01c52e330b8911263eaacfb24c9b940a113da6ce3e5302b15';
    public static $guard = 'user';
    public static function guard($guard)
    {
        static::$guard = $guard;
        return new static;
    }
    public static function attempt($datas)
    {
        $arraySessionAuth = [];
        $classModel = config('auth.guards.' . static::$guard . '.model');
        $query = app()->make($classModel)->whereAttempLogin($datas)->first();
        if ($query) {
            session_regenerate_id();
            $arraySessionAuth[static::$guard] = session_id();

            $cookieValue = json_encode($arraySessionAuth, JSON_UNESCAPED_UNICODE);
            $cookieExpire = time() + (86400 * 30);

            if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
                setcookie('__SESSION_AUTH', $cookieValue, [
                    'expires' => $cookieExpire,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]);
            } else {
                setcookie('__SESSION_AUTH', $cookieValue, $cookieExpire, '/', null, true, true);
            }

            $_SESSION['AUTH_LOGINED_GUARD_' . static::$guard] = $query;
            return new static;
        }
        return false;
    }

    public static function validJWT($token)
    {
        try {
            $decode =  JWT::decode(
                $token,
                new Key(self::JWT_SECRECT_KEY, 'HS256')
            );
            return $decode;
        } catch (\Exception $e) {
            Logger::error("JWT Invalid : " . $e->getMessage());
            return false;
        }
    }

    public static function user()
    {
        return $_SESSION['AUTH_LOGINED_GUARD_' . static::$guard];
    }

    public static function check()
    {
        return isset($_SESSION['AUTH_LOGINED_GUARD_' . static::$guard]);
    }

    public static function logout()
    {
        $cookieSessionIdArray = json_decode($_COOKIE['__SESSION_AUTH'], true);
        foreach ($cookieSessionIdArray as $guard => $sessionId) {
            if ($guard == static::$guard) {
                unset($cookieSessionIdArray[$guard]);
            }
        }
        if (count($cookieSessionIdArray) > 0) {
            $cookieValue = json_encode($cookieSessionIdArray, JSON_UNESCAPED_UNICODE);
            $cookieExpire = time() + (86400 * 30);

            if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
                setcookie('__SESSION_AUTH', $cookieValue, [
                    'expires' => $cookieExpire,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]);
            } else {
                setcookie('__SESSION_AUTH', $cookieValue, $cookieExpire, '/', null, true, true);
            }
        } else {
            if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
                setcookie('__SESSION_AUTH', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]);
            } else {
                setcookie('__SESSION_AUTH', '', time() - 3600, '/', null, true, true);
            }
        }

        unset($_SESSION['AUTH_LOGINED_GUARD_' . static::$guard]);
        return true;
    }

    public static function createToken()
    {
        $key = self::JWT_SECRECT_KEY;
        $expiration = time() + 120;
        $issuer = 'GalaxyFW-GFW';
        $token = [
            'iss' => $issuer,
            'exp' => $expiration,
            'isa' => time(),
            'data' => [
                'guard' => static::$guard,
                'authId' => static::user()->id
            ]
        ];
        return JWT::encode(
            $token,
            $key,
            'HS256',
        );
    }
}
