<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        echo "Trang chủ nè !";
    }
    public function test()
    {
        echo "Test";
    }
}
