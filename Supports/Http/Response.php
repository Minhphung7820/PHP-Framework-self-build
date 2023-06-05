<?php

namespace Supports\Http;

class Response
{
    protected $data;
    public function json($data)
    {
        $this->data[] = $data;
        header('Content-Type: application/json');
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}
