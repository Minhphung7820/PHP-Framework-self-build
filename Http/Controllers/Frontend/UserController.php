<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;
use Supports\Facades\Auth;

class UserController extends BaseController
{
    public function index()
    {
    }
    public function login()
    {
        auth()->attempt(['email' => 'tmpdz7820@gmail.com', 'password' => 123]);
        return redirect('/');
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
