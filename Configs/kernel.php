<?php

use Http\Middlewares\CheckLogin;
use Http\Middlewares\CheckRole;

return [
    'middlewares' => [
        CheckLogin::class,
        CheckRole::class
    ]
];
