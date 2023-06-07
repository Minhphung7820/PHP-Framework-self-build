<?php

namespace App\Models;

use Core\Eloquent;

class BaseModel extends Eloquent
{
    public function __construct($table)
    {
        parent::__construct($table);
    }
}
