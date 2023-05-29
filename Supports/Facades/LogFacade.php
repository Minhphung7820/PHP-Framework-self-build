<?php

namespace Supports\Facades;

class LogFacade
{
    public static function info($message)
    {
        self::log("INFO", $message);
    }
    public static function error($message)
    {
        self::log("ERROR", $message);
    }
    private static function log($level, $message)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        file_put_contents('./Storage/Log/app.log', "[" . $date . "] [" . $level . "] " . $message . PHP_EOL, FILE_APPEND);
    }
}
