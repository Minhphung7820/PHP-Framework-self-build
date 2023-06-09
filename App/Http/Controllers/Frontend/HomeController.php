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
        $redis->rpush("test", json_encode(['e' => 'handle', 'd' => 'Tao nè']));
        $redis->rpush("test2", json_encode(['e' => 'handle', 'd' => 'Tao nè test 2']));
        Queue::getInstance()->worker('test', new \App\Jobs\JobDemo());
        Queue::getInstance()->worker('test2', new \App\Jobs\JobDemo2());
    }
}
