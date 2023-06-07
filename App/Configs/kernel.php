<?php

return [
    'middlewares' => [
        'checkLogin' =>  \App\Http\Middlewares\CheckLogin::class,
        'checkRole' => \App\Http\Middlewares\CheckRole::class,
        'checkJWT' => \App\Http\Middlewares\Auth\JWTvalid::class
    ]
];
