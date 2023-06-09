<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
    }
    public function login()
    {
        $login = auth()->attempt(['email' => 'tmpdz7820@gmail.com', 'password' => 123]);
        if ($login) {
            echo "Login successful <br>";
            echo "Your Token Is : " . $login->createToken();
        } else {
            echo "email or password invalid";
        };
    }
    public function logout()
    {
        auth()->logout();
        return response()->json("Đã đăng xuất !");
    }
}
