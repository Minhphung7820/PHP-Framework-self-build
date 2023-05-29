<?php

namespace Core;

class App
{
    protected $controller;
    protected $method;
    protected array $params;
    protected $urlCurrent;

    public function __construct($url)
    {
        try {
            $this->urlCurrent = explode('/', filter_var(trim($url, '/')));
            $this->controller = (isset($this->urlCurrent[0]) && class_exists('Http\\Controllers\\' . $this->urlCurrent[0])) ? ucfirst($this->urlCurrent[0]) : "Home";
            $controllerNamespace = 'Http\\Controllers\\' . $this->controller;
            $this->controller = new $controllerNamespace;
            $this->method = (isset($this->urlCurrent[1]) && method_exists($this->controller, $this->urlCurrent[1])) ? $this->urlCurrent[1] : "index";
            unset($this->urlCurrent[0]);
            unset($this->urlCurrent[1]);
            $this->params = (isset($this->urlCurrent)) ? array_values($this->urlCurrent) :  [];
            $this->runMiddlewares(config('kernel.middlewares'), $this->controller, $this->method, $this->params);
        } catch (\Throwable $th) {
            throw $th;
        }
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
}
