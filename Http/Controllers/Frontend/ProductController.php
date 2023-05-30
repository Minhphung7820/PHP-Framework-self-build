<?php

namespace Http\Controllers\Frontend;

use Models\ProductsModel;
use Supports\Facades\LogFacade;
use Http\Controllers\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        echo "Đây là index";
    }
    public function detail($slug)
    {
        LogFacade::info("ĐÃ XEM SẢN PHẨM");
        echo "Sản phảm có slug là : " . $slug;
    }
    public function all()
    {
        $kg = ProductsModel::where('id', '=', 1)
            ->where('slug', '=', 'dien-thoai-1')
            ->get();
        echo count($kg);
    }
}
