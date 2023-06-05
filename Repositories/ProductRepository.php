<?php

namespace Repositories;

use Models\ProductsModel;
use Repositories\Interfaces\InterfaceProductRepository;
use Supports\Facades\Logger;

class ProductRepository implements InterfaceProductRepository
{
    protected $prodModel;
    public function __construct(ProductsModel $prodModel)
    {
        $this->prodModel = $prodModel;
    }
    public function getAll()
    {
        return $this->prodModel->all();
    }
}
