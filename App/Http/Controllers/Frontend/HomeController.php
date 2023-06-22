<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Supports\Facades\Auth;
use Supports\Facades\Queue;

class HomeController extends BaseController
{
    public function index()
    {
        echo "HELLO";
    }
}
