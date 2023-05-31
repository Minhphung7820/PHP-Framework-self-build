<?php

namespace Http\Controllers\Api;

use Models\ProductsModel;
use Supports\Facades\LogFacade;

class ProductController
{
    public function detail($slug)
    {
        echo "Đây là trang api chi tiết sản phẩm với slug là : " . $slug;
    }
    public function all()
    {
        echo "Đây là trang api tất cả sản phẩm !";
    }
}
