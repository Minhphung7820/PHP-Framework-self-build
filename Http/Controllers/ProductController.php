<?php

namespace Http\Controllers;

use Supports\Facades\LogFacade;

class ProductController
{
    public function detail($slug)
    {
        LogFacade::info("ĐÃ XEM SẢN PHẨM");
        echo "Sản phảm có slug là : " . $slug;
    }
    public function all()
    {
        echo "Đây là trang tất cả sản phẩm ";
    }
}
