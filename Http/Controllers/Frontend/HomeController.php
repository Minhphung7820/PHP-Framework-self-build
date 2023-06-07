<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;
use Supports\Facades\Auth;

class HomeController extends BaseController
{
    public function index()
    {
        if (Auth::check()) {
            echo "Xin chào " . Auth::user()->fullname;
        } else {
            echo "Chưa đăng nhập";
        }
    }
    public function test()
    {
        echo "Test";
    }
}
