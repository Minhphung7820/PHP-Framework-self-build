<?php

namespace Core\Interfaces;

interface RouterInterface
{
    public function loadRoutes($namespace, $routesWithMidleware, $middleware = []);
}
