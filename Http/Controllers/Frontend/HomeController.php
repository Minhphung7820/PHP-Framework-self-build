<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;
use Supports\Facades\Auth;

class HomeController extends BaseController
{
    public function index()
    {
        if (Auth::check()) {
            echo "Hello " . Auth::user()->fullname;
        } else {
            echo "Not Logged In";
        }
    }
}
