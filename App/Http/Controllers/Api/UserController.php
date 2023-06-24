<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Supports\Http\Request;

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
    public function sendMail(Request $request)
    {
        $data = [
            'email' => 'minhphung485@gmail.com',
            'name' => 'tmp',
            'subject' => 'Demo Queue',
            'body' => $request->body,
        ];
        \App\Jobs\SendMailJob::dispatchNow($data);
        echo "Đã gửi mail";
    }
}
