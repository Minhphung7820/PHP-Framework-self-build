<?php

namespace Supports\Http;

class Response
{
    protected $data;
    public function json($data, $httpStatus = 200)
    {
        $this->data[] = $data;
        header('Content-Type: application/json');
        http_response_code($httpStatus);
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}
