<?php

namespace Core;

use Core\Interfaces\RouterInterface;
use ReflectionFunction;
use ReflectionMethod;

class Router implements RouterInterface
{
    protected string $routeActive = '';
    public function loadRoute($namespace, $routes, $middleware = [])
    {
        $this->handle($namespace, $routes, $middleware);
    }
    protected function url(): string
    {
        return rtrim($_SERVER['REQUEST_URI'], '/') ?: '/';
    }
    protected function run($middlewares, $controller, $method, $params)
    {
        $middleware = array_shift($middlewares);
        if ($middleware) {
            $middlewareInstance = new $middleware();
            $request = [$controller, $method, $params];
            $next = function ($request) use ($middlewares) {
                return $this->run($middlewares, ...$request);
            };
            return $middlewareInstance->handle($request, $next);
        }
        return call_user_func_array([$controller, $method], $params);
    }
    protected function handle($namespace, $routes, $middlewares = [])
    {
        $url = $this->url();
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
                if (!is_callable($handler)) {
                    // handle nếu $handler là dạng folder_path@ClassController@method
                    list($part, $controller, $method) = explode("@", $handler);
                    $controller = "Http\\Controllers\\" . ucfirst($part) . "\\" . $controller;
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
                    $this->run($middlewares, $instanceController, $method, $paramsMethod);
                } else {
                    // handle nếu $handler là dạng anonymous function
                    $reflectionFunction = new ReflectionFunction($handler);
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
                    $handler(...$paramsFunction);
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
