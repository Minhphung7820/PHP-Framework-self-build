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
    public function detail($cate)
    {
        echo "Sản phảm có cate là : " . $cate;
    }
    public function all()
    {
        ConnectDB::beginTransaction();
        try {
            $kg = ProductsModel::where("id", "=", 7)->delete();
            ConnectDB::commit();
        } catch (PDOException $e) {
            Logger::error("ĐÃ XÃY RA LỖI : " . $e->getMessage());
            ConnectDB::rollback();
        }
        return view('frontend.products.index', [
            'kg' => $kg
        ]);
    }
}
