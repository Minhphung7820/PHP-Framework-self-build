<?php

/*
All mapping URLs in the Router/api directory must have the "/api" prefix before the URL.
*/
return [
    'name' => 'api.product',
    'middlewares' => ['checkLogin'],
    'routes' => [
        '/api/san-pham/add' => [
            'handler' => [\Http\Controllers\Api\ProductController::class, 'add'],
        ],
        '/api/san-pham/{slug}' => [
            'handler' => [\Http\Controllers\Api\ProductController::class, 'detail']
        ],
        '/api/san-pham' => [
            'handler' => [\Http\Controllers\Api\ProductController::class, 'all'],
            'middlewares' => ['checkLogin:1:1', 'checkRole:6'],
        ]
    ]
];
