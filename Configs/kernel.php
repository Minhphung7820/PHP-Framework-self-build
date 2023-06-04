<?php

return [
    'middlewares' => [
        'checkLogin' =>  \Http\Middlewares\CheckLogin::class,
        'checkRole' => \Http\Middlewares\CheckRole::class
    ]
];
