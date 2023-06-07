<?php

namespace Supports\Facades;

class Auth
{
    public static $guard = 'users';
    public static function guard($guard)
    {
        self::$guard = $guard;
        return new self;
    }
    public static function attempt($datas)
    {
        $arraySessionAuth = [];
        $classModel = config('auth.guards.' . self::$guard . '.model');
        $query = app()->make($classModel)->whereAttempLogin($datas)->first();
        session_regenerate_id();
        $arraySessionAuth[self::$guard] = session_id();
        setcookie('SESSION_ID_AUTH', json_encode($arraySessionAuth, JSON_UNESCAPED_UNICODE), time() + (86400 * 30));
        $_SESSION['AUTH_LOGINED_GUARD_' . self::$guard] = $query;
        return $query;
    }
    public static function user()
    {
        return $_SESSION['AUTH_LOGINED_GUARD_' . self::$guard];
    }

    public static function check()
    {
        return isset($_SESSION['AUTH_LOGINED_GUARD_' . self::$guard]);
    }

    public static function logout()
    {
        unset($_SESSION['AUTH_LOGINED_GUARD_' . self::$guard]);
        return true;
    }
}
