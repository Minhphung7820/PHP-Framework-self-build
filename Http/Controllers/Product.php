<?php

namespace Http\Controllers;

class Product
{
    public function detail($slug)
    {
        echo "Sản phảm có slug là : " . $slug;
    }
    public function all()
    {
        echo "Đây là trang tất cả sản phẩm ";
    }
}
