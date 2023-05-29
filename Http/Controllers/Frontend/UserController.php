<?php

namespace Http\Controllers\Frontend;

class UserController
{
    public function index()
    {
        echo "Đây là user index";
    }

    public function test($id)
    {
        echo "Đây là user test có id là : " . $id;
    }
}
