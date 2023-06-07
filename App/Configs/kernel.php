<?php

return [
    'middlewares' => [
        'checkLogin' =>  \App\Http\Middlewares\CheckLogin::class,
        'checkRole' => \App\Http\Middlewares\CheckRole::class
    ]
];
