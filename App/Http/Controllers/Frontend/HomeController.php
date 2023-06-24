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
    public function index()
    {
        echo "This Is A Home Page";
    }
}
