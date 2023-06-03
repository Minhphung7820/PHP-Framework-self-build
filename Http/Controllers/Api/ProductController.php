<?php

namespace Http\Controllers\Api;

use Models\ProductsModel;
use Supports\Http\Request;

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
    public function add(Request $request)
    {
        $data = ProductsModel::find(1);
        if (is_object($data)) {
            $result = "Là Object";
        } else {
            $result = "Không phải Object";
        }
        return response()->json($result);
    }
}
