<?php

namespace Core\Base;

abstract class BaseRouter
{
    abstract protected function loadRoutes($namespace, $routesWithMidleware, $middleware = []);
}
