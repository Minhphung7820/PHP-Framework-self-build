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
        if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);
            $routeFile = './Routers/' . $keys[0] . '/' . $keys[1] . '.php';
            if (file_exists($routeFile)) {
                $router = include $routeFile;
                $value = $router;
                return $value;
            }
        } else {
            $routeFile = './Routers/' . $key . '.php';
            if (file_exists($routeFile)) {
                $router = include $routeFile;
                $value = $router;
                return $value;
            }
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
