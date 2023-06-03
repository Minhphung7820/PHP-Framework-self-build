<?php

namespace Core;

use Core\Interfaces\RouterInterface;
use ReflectionFunction;
use ReflectionMethod;

class Router implements RouterInterface
{
    protected string $routeActive = '';

    public function loadRoutes($namespace, $routesWithMidleware, $middlewaresCover = [])
    {
        $this->handleRoutes($namespace, $routesWithMidleware, $middlewaresCover);
    }

    protected function getUrl(): string
    {
        return rtrim($_SERVER['REQUEST_URI'], '/') ?: '/';
    }

    protected function runRouteOnly($middlewares = [], $controller, $method, $params)
    {
        $middleware = array_shift($middlewares);
        if ($middleware) {
            $middlewareInstance = new $middleware();
            $request = [$controller, $method, $params];
            $next = function ($request) use ($middlewares) {
                return $this->runRouteOnly($middlewares, ...$request);
            };
            return $middlewareInstance->handle($request, $next);
        }
        return call_user_func_array([$controller, $method], $params);
    }

    protected function applyMiddlewareCover($middlewares = [], $namespace, $routes)
    {
        // Kiểm tra xem có middleware cho toàn bộ file web không
        if (!empty($middlewares)) {
            // Áp dụng middleware cho toàn bộ file web
            foreach ($middlewares as $middleware) {
                $middlewareInstance = new $middleware();
                $request = [$namespace, $routes, $middlewares];
                $next = function ($request) {
                    return $this->handleRoutes(...$request);
                };
                return $middlewareInstance->handle($request, $next);
            }
        }
    }

    protected function handleRoutes($namespace, $routes, $middlewares = [])
    {
        $this->applyMiddlewareCover($middlewares, $namespace, $routes);
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
                    foreach ($paramsMethodRunning as $param) {
                        if ($param->getType() !== null && $param->getType()->isBuiltin() === false) {
                            $instance = $param->getType()->getName();
                            if (interface_exists($instance)) {
                                $paramsMethod[] = app()->make($instance);
                            } else {
                                $paramsMethod[] = app()->make($instance);
                            }
                        } else {
                            $paramsMethod[] = array_shift($paramsUrl);
                        }
                    }
                    $this->runRouteOnly(array_key_exists('middlewares', $routes[$route]) ? $handler['middlewares'] : [], $instanceController, $method, $paramsMethod);
                } else {
                    // handle nếu $handler là dạng anonymous function
                    $reflectionFunction = new ReflectionFunction($handler['handler']);
                    $paramsFunctionRunning = $reflectionFunction->getParameters();
                    foreach ($paramsFunctionRunning as $param) {
                        if ($param->getType() !== null && $param->getType()->isBuiltin() === false) {
                            $instance = $param->getType()->getName();
                            if (interface_exists($instance)) {
                                $paramsFunction[] = app()->make($instance);
                            } else {
                                $paramsFunction[] = app()->make($instance);
                            }
                        } else {
                            $paramsFunction[] = array_shift($paramsUrl);
                        }
                    }
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
