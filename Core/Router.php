<?php

namespace Core;

use Core\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    protected array $routesNotFound = [];
    protected string $routeAcitve = '';
    public function loadRoute($namespace, $routes, $middleware = [])
    {
        $this->handleRequest($namespace, $routes, $middleware);
    }
    protected function getUrl()
    {
        return (strlen($_SERVER['REQUEST_URI']) > 1) ? rtrim($_SERVER['REQUEST_URI'], "/") : "/";
    }
    protected function runMiddlewares($middlewares, $controller, $method, $params)
    {
        $middleware = array_shift($middlewares);
        if ($middleware) {
            $middlewareInstance = new $middleware();
            $request = [$controller, $method, $params];
            $next = function ($request) use ($middlewares) {
                return $this->runMiddlewares($middlewares, ...$request);
            };
            return $middlewareInstance->handle($request, $next);
        }
        return call_user_func_array([$controller, $method], $params);
    }
    protected function handleRequest($namespace, $routes, $middlewares = [])
    {
        $flag404 = true;
        $url = $this->getUrl();
        $params = [];
        foreach ($routes as $route => $handler) {
            $routeMapping = $route;
            $patternParamMapping = '|\{([\w-]+)\}|';
            $routeRegex = '|^' . preg_replace($patternParamMapping, '([\w-]+)',  $routeMapping) . '$|';
            if (preg_match($routeRegex, $url, $matches)) {
                if (strpos($routeMapping, '{') !== false && strpos($routeMapping, '}') !== false) {
                    $countParams = substr_count($routeMapping, "{");
                    for ($i = 1; $i <= $countParams; $i++) {
                        $params[] = $matches[$i];
                    }
                } else {
                    $params = [];
                }
                list($part, $controller, $method) = explode("@", $handler);
                $controller = 'Http\\Controllers\\' . $part . '\\' . $controller;
                $instanceController = app()->make($controller);
                $this->runMiddlewares($middlewares, $instanceController, $method, $params);
                $this->routeAcitve = $namespace;
                $flag404 = false;
                break;
            }
        }
        if ($flag404) {
            $this->routesNotFound[$namespace] = 0;
        }
    }
    protected function handleRoutNotFound()
    {
        if ($this->routeAcitve === '') {
            http_response_code(404);
        }
    }
}
