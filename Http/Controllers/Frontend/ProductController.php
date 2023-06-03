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
    protected $b;
    public function __construct(InterfaceProductRepository $repoProd, $a, $b)
    {
        $this->repoProd = $repoProd;
        $this->a = $a;
        $this->b = $b;
    }
    public function index()
    {
        echo "Đây là index";
    }
    public function detail(ProductsModel $prodModel, string $cate, string $slug)
    {
        echo $this->a . "<br>";
        echo $this->b . "<br>";
        echo "Cate là : " . $cate . "<br>";
        echo "Slug là : " . $slug . "<br>";
        echo $prodModel->where('id', '=', 1)->first()->name . "<br>";
        echo count($prodModel->all()) . "<br>";
        $this->repoProd->getAll();
    }
    public function all(ProductsModel $prodModel)
    {
        $datas = $prodModel->all();
        return view('frontend.products.index', ['datas' => $datas]);
    }
}
