<?php

namespace Supports\Http;

class Request
{
    private $data;

    public function __construct()
    {
        $this->data = $_POST;
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

    public function all()
    {
        return $this->data;
    }
}
