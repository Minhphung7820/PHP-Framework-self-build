<?php

namespace App\Http\Controllers\Frontend;

use App\Events\AfterRegisted;
use App\Events\DemoEvent;
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
            'email' => 'phungtmps15106@fpt.edu.vn',
            'name' => 'GalaxyFW',
            'subject' => 'Demo Event',
            'body' => 'This is Event Demo',
        ];
        Event::dispatch(new DemoEvent($data));
        // echo "This is Home page";
    }
}
