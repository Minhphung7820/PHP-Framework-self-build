<?php

return [
    'middlewares' => [
        \Http\Middlewares\CheckLogin::class,
        \Http\Middlewares\CheckRole::class
    ]
];
