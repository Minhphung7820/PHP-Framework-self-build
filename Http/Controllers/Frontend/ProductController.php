<?php

namespace Http\Controllers\Frontend;

use Core\ConnectDB;
use Models\ProductsModel;
use Http\Controllers\BaseController;
use PDOException;
use Supports\Facades\Logger;

class ProductController extends BaseController
{
    public function index()
    {
        echo "Đây là index";
    }
    public function detail($slug)
    {
        $data = ProductsModel::where('slug', '=', $slug)->where('id', '=', 1)->first();

        return view('frontend.products.detail', [
            'data' => $data
        ]);
    }
    public function all()
    {
        $prods = ProductsModel::all();
        return view('frontend.products.index', [
            'prods' => $prods
        ]);
    }
}
