<?php

namespace Core\Interfaces;

interface RouterInterface
{
    public function loadRoute($namespace, $routes, $middleware = []);
}
