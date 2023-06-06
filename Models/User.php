<?php

namespace Models;

use Core\Eloquent;

class User extends BaseModel
{
    protected static $table = 'users';
    public function __construct()
    {
        parent::__construct(static::$table);
    }
}
