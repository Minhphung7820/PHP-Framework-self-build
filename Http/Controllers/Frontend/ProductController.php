<?php

namespace Http\Controllers\Frontend;

use Models\ProductsModel;
use Http\Controllers\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        echo "Đây là index";
    }
    public function detail($cate, $slug)
    {
        echo "Sản phảm có slug là : " . $slug . " và cate là : " . $cate;
    }
    public function all()
    {
        $kg = ProductsModel::where('id', '=', 2)
            ->orWhere('slug', '=', 'dien-thoai-1')
            ->get();
        return view('frontend.products.index', ['kg' => $kg]);
    }
}
