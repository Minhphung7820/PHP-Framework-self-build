<?php

namespace Supports\Facades;

class NextClosure
{
    protected array $middlewares;
    protected $router;
    protected $option;
    public function __construct(array $middlewares, \Core\Router $router, $option)
    {
        $this->middlewares = $middlewares;
        $this->router = $router;
        $this->option = $option;
    }

    public function __invoke($request)
    {
        switch ($this->option) {
            case 'ONLY':
                return $this->router->runRouteOnly($this->middlewares, ...$request);
                break;
            case 'COVER':
                return $this->router->handleRoutes(...$request);
                break;
            default:
                return null;
                break;
        }
    }
}
