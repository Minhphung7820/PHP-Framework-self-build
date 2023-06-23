<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\User;
use Supports\Facades\Auth;
use Supports\Facades\Queue;

class HomeController extends BaseController
{
    public function index()
    {
        $data = ProductsModel::where('id', '=', 1)->orWhere('id', '=', 2)->orWhere('id', '=', 6)->get();
        echo count($data);
    }
}
