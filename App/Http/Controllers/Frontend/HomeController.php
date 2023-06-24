<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\User;
use Supports\Facades\Auth;
use Supports\Facades\Queue;
use Supports\Facades\Mail;
use Supports\Http\Request;

class HomeController extends BaseController
{
    public function index(Request $request)
    {
        $data = [
            'email' => 'minhphung485@gmail.com',
            'name' => 'Phụng',
            'subject' => 'Test queue - GFW',
            'body' => $request->body
        ];
        \App\Jobs\SendMailJob::dispatchNow($data);
    }
}
