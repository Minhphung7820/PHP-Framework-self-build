<?php

namespace Http\Controllers\Frontend;

use Models\ProductsModel;
use Http\Controllers\BaseController;
use Predis\Client;
use Repositories\Interfaces\InterfaceProductRepository;
use stdClass;

class ProductController extends BaseController
{

    protected $repoProd;
    protected $a;
    public function __construct(InterfaceProductRepository $repoProd)
    {
        $this->repoProd = $repoProd;
    }
    public function index()
    {
        echo "Đây là index";
    }
    public function detail(InterfaceProductRepository $repoProd, ProductsModel $prodModel, string $cate, string $slug)
    {
        echo "Cate là : " . $cate . "<br>";
        echo "Slug là : " . $slug . "<br>";
        echo $prodModel->where('id', '=', 1)->first()->name . "<br>";
        echo count($prodModel->all()) . "<br>";
        $repoProd->getAll();
    }
    public function all($a, $b)
    {
    }
}
