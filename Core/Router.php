<?php

namespace Core;

use Core\Base\BaseRouter;
use ReflectionFunction;
use ReflectionMethod;

class Router extends BaseRouter
{
    protected array $routes = [];

    protected function getUrl(): string
    {
        return rtrim($_SERVER['REQUEST_URI'], '/') ?: '/';
    }

    protected function register(array $routes): void
    {
        $this->routes[$routes['name']] = $routes;
    }

    protected function resolveParams($paramsHandle, array $continue)
    {
        $paramsToRun = [];
        foreach ($paramsHandle as $param) {
            if ($param->getType() !== null && !$param->getType()->isBuiltin()) {
                $instance = $param->getType()->getName();
                $paramsToRun[] = app()->make($instance);
            } else {
                $paramsToRun[] = array_shift($continue);
            }
        }
        return $paramsToRun;
    }

    protected function handleMiddleware($middleware): bool
    {
        $arguments = explode(":", rtrim($middleware, ":"));
        unset($arguments[0]);
        $className = classNameMiddleware($middleware);
        $instanceMiddleware = new $className();
        $request = new \Supports\Http\Request();
        $request->NEXT_REQUEST = true;
        $sortedParams = [];
        $reflection = new ReflectionMethod($className, 'handle');
        $parameters = $reflection->getParameters();

        foreach ($parameters as $key => $parameter) {
            if ($parameter->getType() !== null && !$parameter->getType()->isBuiltin()) {
                if ($parameter->getType()->getName() === \Supports\Http\Request::class) {
                    $sortedParams[$key] = $request;
                } else {
                    $sortedParams[$key] = app()->make($parameter->getType()->getName());
                }
            } else {
                $sortedParams[$key] = array_shift($arguments);
            }
        }

        $result = $instanceMiddleware->handle(...$sortedParams);
        return ($result === true) ? $result : false;
    }

    protected function shouldContinueRequest(array $middlewares): bool
    {
        $arrResults = array_filter(array_map([$this, 'handleMiddleware'], $middlewares));
        return count($arrResults) === count($middlewares);
    }

    protected function handleController($controller, $method, $paramsMethod)
    {
        $instanceController = app()->make($controller);
        $reflectionMethod = new ReflectionMethod($controller, $method);
        $paramsMethodRunning = $reflectionMethod->getParameters();
        $paramsMethod = $this->resolveParams($paramsMethodRunning, $paramsMethod);
        call_user_func_array([$instanceController, $method], $paramsMethod);
    }

    protected function handleAnonymousFunction($handler, $paramsFunction)
    {
        $reflectionFunction = new ReflectionFunction($handler);
        $paramsFunctionRunning = $reflectionFunction->getParameters();
        $paramsFunction = $this->resolveParams($paramsFunctionRunning, $paramsFunction);
        $handler(...$paramsFunction);
    }

    protected function runRoutes()
    {
        $paramsUrl = [];

        foreach ($this->routes as $nameRouter => $router) {
            foreach ($router['routes'] as $route => $handler) {
                $routeMapping = rtrim($route, "/");
                $patternParamMapping = '|\{([\w-]+)\}|';
                $routeRegex = '|^' . preg_replace($patternParamMapping, '([\w-]+)', $routeMapping) . '$|';

                if (preg_match($routeRegex, $this->getUrl(), $matches)) {
                    $allMiddlewaresFilePassed = $this->shouldContinueRequest($router['middlewares'] ?? []);

                    if ($allMiddlewaresFilePassed) {
                        if (strpos($routeMapping, '{') !== false && strpos($routeMapping, '}') !== false) {
                            for ($i = 1; $i <= count($matches) - 1; $i++) {
                                $paramsUrl[] = $matches[$i];
                            }
                        }

                        $allMiddlewaresSingleRoutePassed = $this->shouldContinueRequest($handler['middlewares'] ?? []);

                        if (is_array($handler['handler'])) {
                            list($controller, $method) = $handler['handler'];
                            if ($allMiddlewaresSingleRoutePassed) {
                                $this->handleController($controller, $method, $paramsUrl);
                            }
                        } else {
                            if ($allMiddlewaresSingleRoutePassed) {
                                $this->handleAnonymousFunction($handler['handler'], $paramsUrl);
                            }
                        }
                        break;
                    }
                }
            }
        }
    }
}
