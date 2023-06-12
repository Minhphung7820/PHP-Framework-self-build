<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Supports\Facades\Auth;
use Supports\Facades\Queue;

class HomeController extends BaseController
{
    public function index()
    {
        $redis = Queue::getInstance()->redis;
        $redis->rpush("test", json_encode(['e' => 'handle', 'd' => ['cc']]));
        $redis->rpush("test2", json_encode(['e' => 'handle', 'd' => ['samsung']]));
        Queue::getInstance()->worker('test1', \App\Jobs\JobDemo::class);
        echo "CC";
        Queue::getInstance()->worker('test2', \App\Jobs\JobDemo2::class);
        echo "CCx";
    }
}
