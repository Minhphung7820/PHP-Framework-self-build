<?php

namespace Http\Controllers\Frontend;

use Models\ProductsModel;
use Http\Controllers\BaseController;
use Models\User;
use Predis\Client;
use Repositories\Interfaces\InterfaceProductRepository;
use stdClass;
use Supports\Facades\Auth;

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
        $data = $prodModel->where('id', '=', 1)->first();
        echo count($prodModel->all()) . "<br>";

        $this->repoProd->getAll();

        return view('frontend.products.detail', [
            'data' => $data
        ]);
    }
    public function all(ProductsModel $prodModel, User $userModel)
    {
        // $datas = $prodModel->all();
        // return view('frontend.products.index', ['datas' => $datas]);
        Auth::attempt(['email' => 'tmpdz7820@gmail.com', 'password' => 123]);
        if (Auth::check()) {
            echo "Xin chào " . Auth::user()->fullname;
        } else {
            echo "Chưa đăng nhập !";
        }
    }
}
