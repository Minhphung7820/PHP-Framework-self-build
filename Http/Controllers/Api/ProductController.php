<?php

namespace Http\Controllers\Api;

use Http\Controllers\BaseController;
use Repositories\Interfaces\InterfaceProductRepository;
use Supports\Http\Request;

class ProductController extends BaseController
{
    protected $repoProduct;
    public function __construct(InterfaceProductRepository $repoProduct)
    {
        $this->repoProduct = $repoProduct;
    }
    public function index()
    {
        $data = $this->repoProduct->getAll();
        return response()->json($data);
    }
    public function detail($slug)
    {
        return response()->json('Sản phẩm với slug là : ' . $slug);
    }
    public function create(Request $request)
    {
    }
}
