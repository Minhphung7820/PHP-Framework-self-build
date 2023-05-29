<?php

namespace Http\Controllers;

class User
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
