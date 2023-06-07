<?php
if (!function_exists('config')) {
    function config($key)
    {
        $keys = explode('.', $key);
        $configFile = './Configs/' . $keys[0] . '.php';
        unset($keys[0]);
        if (file_exists($configFile)) {
            $config = include $configFile;

            $value = $config;

            foreach ($keys as $k) {
                if (!isset($value[$k])) {
                    return null;
                }
                $value = $value[$k];
            }

            return $value;
        }

        return null;
    }
}

if (!function_exists('router')) {
    function router($key)
    {
        $routeFile = './Routers/' . str_replace('.', '/', $key) . '.php';
        if (file_exists($routeFile)) {
            $router = include $routeFile;
            $value = $router;
            return $value;
        }
    }
}

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}

if (!function_exists('view')) {
    function view($viewPath, $data = [])
    {
        $filePath = './Views/' . str_replace('.', '/', $viewPath) . '.php';
        if (file_exists($filePath)) {
            ob_start();
            extract($data);
            include $filePath;
            return ob_get_contents();
        }
        throw new Exception("View [$viewPath] not found.");
    }
}

if (!function_exists('db')) {
    function db()
    {
        return new Core\ConnectDB();
    }
}

if (!function_exists('now')) {
    function now()
    {
        return new \Carbon\Carbon();
    }
}

if (!function_exists('response')) {
    function response()
    {
        return new \Supports\Http\Response();
    }
}

if (!function_exists('app')) {
    function app()
    {
        return \Core\App::getContainer();
    }
}

if (!function_exists('request')) {
    function request()
    {
        return new \Supports\Http\Request();
    }
}

if (!function_exists('abort')) {
    function abort($code)
    {
        http_response_code($code);
        include('./Views/errors/' . $code . '.html');
        exit();
    }
}

if (!function_exists('cache')) {
    function cache()
    {
        return new \Predis\Client();
    }
}

if (!function_exists('classMiddleware')) {
    function classNameMiddleware($name)
    {
        return config('kernel.middlewares')[explode(":", $name)[0]];
    }
}

if (!function_exists('auth')) {
    function auth()
    {
        return new \Supports\Facades\Auth();
    }
}
