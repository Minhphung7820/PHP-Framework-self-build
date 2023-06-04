<?php

namespace Http\Controllers\Api;

class UserController
{
    public function detail($id)
    {
        echo "Đây là trang api chi tuser với id là : " . $id;
    }
    public function all()
    {
        echo "Đây là trang api tất cả users !";
    }
}
