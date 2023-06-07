<?php

namespace Supports\Facades;

class Auth
{
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
                setcookie('SESSION_ID_AUTH', $cookieValue, [
                    'expires' => $cookieExpire,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]);
            } else {
                setcookie('SESSION_ID_AUTH', $cookieValue, $cookieExpire, '/', null, true, true);
            }

            $_SESSION['AUTH_LOGINED_GUARD_' . static::$guard] = $query;
            return true;
        }
        return false;
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
        $cookieSessionIdArray = json_decode($_COOKIE['SESSION_ID_AUTH'], true);
        foreach ($cookieSessionIdArray as $guard => $sessionId) {
            if ($guard == static::$guard) {
                unset($cookieSessionIdArray[$guard]);
            }
        }
        if (count($cookieSessionIdArray) > 0) {
            $cookieValue = json_encode($cookieSessionIdArray, JSON_UNESCAPED_UNICODE);
            $cookieExpire = time() + (86400 * 30);

            if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
                setcookie('SESSION_ID_AUTH', $cookieValue, [
                    'expires' => $cookieExpire,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]);
            } else {
                setcookie('SESSION_ID_AUTH', $cookieValue, $cookieExpire, '/', null, true, true);
            }
        } else {
            if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
                setcookie('SESSION_ID_AUTH', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]);
            } else {
                setcookie('SESSION_ID_AUTH', '', time() - 3600, '/', null, true, true);
            }
        }

        unset($_SESSION['AUTH_LOGINED_GUARD_' . static::$guard]);
        return true;
    }
}
