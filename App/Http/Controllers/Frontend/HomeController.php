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
        $data = ProductsModel::where('id', '=', 6)->get();
        foreach ($data as $key => $value) {
            echo $value->name . "<br>";
        }
    }
}
