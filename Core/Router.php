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
            if ($param->getType() !== null && $param->getType()->isBuiltin() === false) {
                $instance = $param->getType()->getName();
                $paramsToRun[] = app()->make($instance);
            } else {
                $paramsToRun[] = array_shift($continue);
            }
        }
        return $paramsToRun;
    }

    protected function handleMiddleware($middleware)
    {
        $className = classNameMiddleware($middleware);
        $instanceMiddleware = new $className();
        $request = true;
        $next = function ($request) {
            return $request;
        };
        $result = $instanceMiddleware->handle($next, $request);
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
                $arrResults[] = $this->handleMiddleware($middleware);
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
    protected function runRoutes()
    {
        $paramsUrl = [];
        $paramsMethod = [];
        $paramsFunction = [];
        foreach ($this->routes as $nameRouter => $router) {
            foreach ($router['routes'] as $route => $handler) {
                // Xử lý route như trước
                $routeMapping = $route;
                $patternParamMapping = '|\{([\w-]+)\}|';
                $routeRegex = '|^' . preg_replace($patternParamMapping, '([\w-]+)',  $routeMapping) . '$|';
                if (preg_match($routeRegex, $this->getUrl(), $matches)) {

                    // Nếu thỏa hết tất cả middleware thì tiến hành sử lý các route bên trong
                    $allMiddlewaresFilePassed = $this->shouldContinueRequest(isset($router['middlewares']) ? $router['middlewares'] : []);
                    if ($allMiddlewaresFilePassed) {
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
                            call_user_func_array([$instanceController, $method], $paramsMethod);
                        } else {
                            // handle nếu $handler là dạng anonymous function
                            $reflectionFunction = new ReflectionFunction($handler['handler']);
                            $paramsFunctionRunning = $reflectionFunction->getParameters();
                            $paramsFunction = $this->resolveParams($paramsFunctionRunning, $paramsUrl);
                            $handler['handler'](...$paramsFunction);
                        }
                        break;
                    }
                }
            }
        }
    }
}
