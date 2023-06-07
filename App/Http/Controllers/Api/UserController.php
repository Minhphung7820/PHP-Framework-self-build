<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
    }
    public function detail($id)
    {
        echo "Đây là trang api chi tuser với id là : " . $id;
    }
    public function all()
    {
        echo "Đây là trang api tất cả users !";
    }
}
