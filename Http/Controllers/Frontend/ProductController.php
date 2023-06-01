<?php

namespace Http\Controllers\Frontend;

use Models\ProductsModel;
use Http\Controllers\BaseController;
use Repositories\Interfaces\InterfaceProductRepository;


class ProductController extends BaseController
{

    protected $repoProd;
    public function __construct(InterfaceProductRepository $repoProd)
    {
        $this->repoProd = $repoProd;
    }
    public function index()
    {
        echo "Đây là index";
    }
    public function detail($slug)
    {
        $data = ProductsModel::where('slug', '=', $slug)->where('id', '=', 1)->first();

        return view('frontend.products.detail', [
            'data' => $data
        ]);
    }
    public function all()
    {
        $this->repoProd->getAll() . "<br>";
    }
}
