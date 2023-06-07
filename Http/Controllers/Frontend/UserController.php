<?php

namespace Http\Controllers\Frontend;

use Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
    }
    public function login()
    {
        if (auth()->attempt(['email' => 'tmpdz7820@gmail.com', 'password' => 123])) {
            echo "Login successful";
        } else {
            echo "email or password invalid";
        };
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
