<?php

namespace Http\Controllers\Api;

class UserController
{
    public function index()
    {
        echo "Đây là api user index";
    }

    public function test($id)
    {
        echo "Đây là api user test có id là : " . $id;
    }
}
