<?php

namespace Core;

use Core\Base\BaseRouter;
use ReflectionFunction;
use ReflectionMethod;

class Router extends BaseRouter
{
    protected string $routeActive = '';

    protected function loadRoutes($namespace, $routesWithMidleware, $middlewaresCover = [])
    {
        (count($middlewaresCover) > 0) ?
            $this->applyMiddlewareCover($middlewaresCover, $namespace, $routesWithMidleware) :
            $this->handleRoutes($namespace, $routesWithMidleware, $middlewaresCover);
    }

    protected function getUrl(): string
    {
        return rtrim($_SERVER['REQUEST_URI'], '/') ?: '/';
    }

    protected function resolveParams($paramsHandle, $continute)
    {
        $paramsToRun = [];
        foreach ($paramsHandle as $param) {
            if ($param->getType() !== null && $param->getType()->isBuiltin() === false) {
                $instance = $param->getType()->getName();
                $paramsToRun[] = app()->make($instance);
            } else {
                $paramsToRun[] = array_shift($continute);
            }
        }
        return $paramsToRun;
    }

    protected function runMiddleware($classMiddleware, array $continute)
    {
        $instanceMiddleware = new $classMiddleware();
        $paramsToRun = $this->resolveParams(
            (new ReflectionMethod($classMiddleware, 'handle'))->getParameters(),
            $continute
        );
        return call_user_func_array([$instanceMiddleware, 'handle'], $paramsToRun);
    }

    public function runRouteOnly($middlewares = [], $controller, $method, $params)
    {
        $middleware = array_shift($middlewares);
        if ($middleware) {
            $request = [$controller, $method, $params];
            $next = new \Supports\Facades\NextClosure($middlewares, $this, 'ONLY');
            return $this->runMiddleware($middleware, [$request, $next]);
        }
        return call_user_func_array([$controller, $method], $params);
    }

    protected function applyMiddlewareCover($middlewares = [], $namespace, $routes)
    {
        // Kiểm tra xem có middleware cho toàn bộ file web không
        if (!empty($middlewares)) {
            // Áp dụng middleware cho toàn bộ file web
            foreach ($middlewares as $middleware) {
                $request = [$namespace, $routes, $middlewares];
                $next = new \Supports\Facades\NextClosure([], $this, 'COVER');
                return $this->runMiddleware($middleware, [$request, $next]);
            }
        }
    }

    public function handleRoutes($namespace, $routes)
    {
        $url = $this->getUrl();
        $paramsUrl = [];
        $paramsMethod = [];
        $paramsFunction = [];
        foreach ($routes as $route => $handler) {
            $routeMapping = $route;
            $patternParamMapping = '|\{([\w-]+)\}|';
            $routeRegex = '|^' . preg_replace($patternParamMapping, '([\w-]+)',  $routeMapping) . '$|';
            if (preg_match($routeRegex, $url, $matches)) {
                if (strpos($routeMapping, '{') !== false && strpos($routeMapping, '}') !== false) {
                    for ($i = 1; $i <= count($matches) - 1; $i++) {
                        $paramsUrl[] = $matches[$i];
                    }
                }
                if (is_array($handler['handler'])) {
                    // handle nếu $handler là dạng [\Http\Controllers\Frontend\HomeController::class, 'index']
                    list($controller, $method) = $handler['handler'];
                    $instanceController = app()->make($controller);
                    $reflectionMethod = new ReflectionMethod($controller, $method);
                    $paramsMethodRunning = $reflectionMethod->getParameters();
                    $paramsMethod = $this->resolveParams($paramsMethodRunning, $paramsUrl);
                    $this->runRouteOnly(array_key_exists('middlewares', $routes[$route]) ? $handler['middlewares'] : [], $instanceController, $method, $paramsMethod);
                } else {
                    // handle nếu $handler là dạng anonymous function
                    $reflectionFunction = new ReflectionFunction($handler['handler']);
                    $paramsFunctionRunning = $reflectionFunction->getParameters();
                    $paramsFunction = $this->resolveParams($paramsFunctionRunning, $paramsUrl);
                    $handler['handler'](...$paramsFunction);
                }
                $this->routeActive = $namespace;
                break;
            }
        }
    }

    protected function notFound()
    {
        if ($this->routeActive === '') {
            abort(404);
        }
    }
}
