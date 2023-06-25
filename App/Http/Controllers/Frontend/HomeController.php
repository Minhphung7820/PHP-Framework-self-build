<?php

namespace App\Http\Controllers\Frontend;

use App\Events\AfterRegisted;
use App\Http\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\User;
use Supports\Facades\Auth;
use Supports\Facades\Event;
use Supports\Facades\Queue;
use Supports\Facades\Mail;
use Supports\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'email' => 'minhphung485@gmail.com',
            'name' => 'tmp',
            'subject' => 'Demo Queue',
            'body' => "qưerrr",
        ];
        $data1 = [
            'email' => 'phungtmps15106@fpt.edu.vn',
            'name' => 'tmp',
            'subject' => 'Demo Queue',
            'body' => "qưerrr",
        ];
        \App\Jobs\SendMailJob::dispatchNow($data1);
        Event::dispatch(new AfterRegisted($data));
        echo "This Is A Home Page";
        // $arr = array(new AfterRegisted($data), "Fdf", 123, "KJ");

        // $js = serialize($arr);
        // $rs = unserialize($js);
        // echo "<pre>";
        // print_r($rs);
        // echo "</pre>";
    }
}
