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

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}
