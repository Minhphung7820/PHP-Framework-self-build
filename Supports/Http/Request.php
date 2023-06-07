<?php

namespace Supports\Http;

class Request
{
    private $data;
    private $method;
    public function __construct()
    {
        $this->data = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        return $this;
    }

    public function input($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }

    public function __get($name)
    {
        return $this->input($name);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function all()
    {
        return $this->data;
    }

    public function isMethod()
    {
        return  $this->method;
    }

    public function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function header($name)
    {
        $headers = getallheaders();
        $authorizationHeader = isset($headers[$name]) ? $headers[$name] : '';
        return $authorizationHeader;
    }
}
