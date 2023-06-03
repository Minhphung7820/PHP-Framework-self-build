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
    public function __construct(InterfaceProductRepository $repoProd, $a, $b)
    {
        $this->repoProd = $repoProd;
        $this->a = $a;
    }
    public function index()
    {
        echo "Đây là index";
    }
    public function detail(ProductsModel $prodModel, string $cate, string $slug)
    {
        echo $this->a . "<br>";
        echo "Cate là : " . $cate . "<br>";
        echo "Slug là : " . $slug . "<br>";
        echo $prodModel->where('id', '=', 1)->first()->name . "<br>";
        echo count($prodModel->all()) . "<br>";
        $this->repoProd->getAll();
    }
    public function all($a, $b)
    {
    }
}
