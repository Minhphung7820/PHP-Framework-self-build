<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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
