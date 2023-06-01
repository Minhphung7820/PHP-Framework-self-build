<?php

namespace Repositories;

use Repositories\Interfaces\InterfaceProductRepository;

class ProductRepository implements InterfaceProductRepository
{
    public function getAll()
    {
        echo "Đây là REPO GETALL PRODUCTS";
    }
}
