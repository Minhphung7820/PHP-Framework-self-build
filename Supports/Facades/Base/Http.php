<?php

namespace Supports\Facades\Base;

abstract class Http
{
    abstract public static function get();
    abstract public static function post();
    abstract public static function withHeaders();
}
