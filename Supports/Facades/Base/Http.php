<?php

namespace Supports\Facades\Base;

abstract class Http
{
    abstract public static function get($url, $data = []);
    abstract public static function post($url, $data = []);
    abstract public static function put($url, $data = []);
    abstract public static function patch($url, $data = []);
    abstract public static function delete($url, $data = []);
    abstract public static function withHeaders(array $headers);
    abstract protected static function setHeaders($curl);
}
