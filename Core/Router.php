<?php

namespace Core;

use Core\Base\BaseRouter;
use ReflectionFunction;
use ReflectionMethod;

class Router extends BaseRouter
{
    protected array $pathRoutes = [];
    protected array $middlewares = [];
    protected array $routesMapping = [];
    protected array $arrayPrefixs = [];

    protected function getUrl(): string
    {
        return rtrim($_SERVER['REQUEST_URI'], '/') ?: '/';
    }

    protected function register(string $path): void
    {
        $this->pathRoutes[$path] = $path;
    }

    public function add(string $url, $handler, array $middlewares = []): void
    {
        $perfectUrl = rtrim(implode("/", $this->arrayPrefixs), "/") . $url;
        if (substr($perfectUrl, 0, 1) !== "/") {
            $perfectUrl = "/" . $perfectUrl;
        }
        $this->routesMapping[$perfectUrl] = [
            'middlewares' => array_merge($this->middlewares, $middlewares),
            'handler' => $handler
        ];
    }

    public function group(string $prefix = null, callable $callback, array $middlewares = []): void
    {
        $previousPrefix = $this->arrayPrefixs;
        $previousMiddlwares = $this->middlewares;
        $this->arrayPrefixs[] = trim($prefix, "/");
        foreach ($middlewares as $middleware) {
            $this->middlewares[] = $middleware;
        }
        $callback();
        $this->arrayPrefixs = $previousPrefix;
        $this->middlewares = $previousMiddlwares;
    }

    protected function resolveParams($paramsHandle, array $continue): array
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
        // Kiểm tra xem route có middleware không
        $flag = true;
        $arrSuccess = [];
        if (isset($middlewares)) {
            $arrResults = [];
            foreach ($middlewares as  $middleware) {
                if (!$this->handleMiddleware($middleware)) {
                    return false;
                } else {
                    $arrResults[] = true;
                }
            }
            foreach ($arrResults as $result) {
                if ($result) {
                    $arrSuccess[] = 1;
                }
            }
            // Nếu tất cả các middlewa không thỏa thì $flag = false
            if (count($arrSuccess) !== count($middlewares)) {
                $flag = false;
            }
        }
        return $flag;
    }

    protected function handleController($controller, $method, $paramsMethod): void
    {
        $instanceController = app()->make($controller);
        $reflectionMethod = new ReflectionMethod($controller, $method);
        $paramsMethodRunning = $reflectionMethod->getParameters();
        $paramsMethod = $this->resolveParams($paramsMethodRunning, $paramsMethod);
        call_user_func_array([$instanceController, $method], $paramsMethod);
    }

    protected function handleAnonymousFunction($handler, $paramsFunction): void
    {
        $reflectionFunction = new ReflectionFunction($handler);
        $paramsFunctionRunning = $reflectionFunction->getParameters();
        $paramsFunction = $this->resolveParams($paramsFunctionRunning, $paramsFunction);
        $handler(...$paramsFunction);
    }

    protected function runRoutes(): void
    {
        foreach ($this->pathRoutes as $path) {
            include './App/Routers/' .  $path;
        }
        // echo "<pre>";
        // print_r($this->routesMapping);
        // echo "</pre>";
        $paramsUrl = [];
        foreach ($this->routesMapping as $route => $handler) {
            $routeMapping = strlen($route) > 1 ? rtrim($route, "/") : "/";
            $patternParamMapping = '|\{([\w-]+)\}|';
            $routeRegex = '|^' . preg_replace($patternParamMapping, '([\w-]+)', $routeMapping) . '$|';
            if (preg_match($routeRegex, $this->getUrl(), $matches)) {

                if (strpos($routeMapping, '{') !== false && strpos($routeMapping, '}') !== false) {
                    for ($i = 1; $i <= count($matches) - 1; $i++) {
                        $paramsUrl[] = $matches[$i];
                    }
                }

                $allMiddlewaresRoutePassed = $this->shouldContinueRequest($handler['middlewares'] ?? []);

                if (is_array($handler['handler'])) {
                    list($controller, $method) = $handler['handler'];
                    if ($allMiddlewaresRoutePassed) {
                        $this->handleController($controller, $method, $paramsUrl);
                    }
                } else {
                    if ($allMiddlewaresRoutePassed) {
                        $this->handleAnonymousFunction($handler['handler'], $paramsUrl);
                    }
                }
                break;
            }
        }
    }
}
