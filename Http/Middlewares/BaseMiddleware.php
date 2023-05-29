<?php

namespace Http\Middlewares;

abstract class BaseMiddleware
{
    abstract protected function handle($request, $next);
}
