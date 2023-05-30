<?php

namespace Core\Interfaces;

interface RouterInterface
{
    public function loadRouteFrom($routes, $middleware = []);
}
