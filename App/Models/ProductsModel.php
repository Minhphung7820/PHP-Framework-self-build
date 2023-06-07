<?php

namespace App\Models;

class ProductsModel extends BaseModel
{
    protected static $table = 'products';
    public function __construct()
    {
        parent::__construct(static::$table);
    }
}
