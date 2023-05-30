<?php

namespace Core;

use Core\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    protected string $routeNotFound;
    protected array $routesNotFound;
    public function loadRouteFrom($routes, $middleware = [])
    {
        $this->handleRequest($routes, $middleware);
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
    protected function handleRequest($routes, $middlewares = [])
    {
        $url = $this->getUrl();
        foreach ($routes as $route => $handler) {
            // Tách các phần của route và URL thành mảng
            $routeParts = explode('/', $route);
            $urlParts = explode('/', $url);

            // Kiểm tra số lượng phần của route và URL
            if (count($routeParts) !== count($urlParts)) {
                continue; // Không khớp, tiếp tục với route khác
            }

            $parameters = [];

            // Kiểm tra từng phần của route và URL
            for ($i = 0; $i < count($routeParts); $i++) {
                if ($routeParts[$i] === $urlParts[$i]) {
                    continue; // Phần tĩnh khớp, tiếp tục với phần tiếp theo
                }

                // Kiểm tra nếu là một tham số động (được đặt trong dấu ngoặc nhọn)
                if (strpos($routeParts[$i], '{') === 0 && strpos($routeParts[$i], '}') === strlen($routeParts[$i]) - 1) {
                    // Lưu giá trị tham số vào mảng parameters
                    $parameterName = trim($routeParts[$i], '{}');
                    $parameterValue = $urlParts[$i];
                    $parameters[$parameterName] = $parameterValue;
                } else {
                    // Không khớp, tiếp tục với route khác
                    continue 2;
                }
            }
            // Route khớp được tìm thấy
            $params = array_values($parameters);
            list($part, $controller, $method) = explode("@", $handler);
            $controller = 'Http\\Controllers\\' . $part . '\\' . $controller;
            $instanceController = new $controller();
            $this->runMiddlewares($middlewares, $instanceController, $method, $params);
            // Xử lý tương ứng với route tìm thấy
            break;
        }
    }
}
