<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ProductsModel;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Predis\Client;
use App\Repositories\Interfaces\InterfaceProductRepository;
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
        echo "Đây là trang tất cả sản phẩm ";
    }
}
