<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;

class UserController extends BaseController
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
