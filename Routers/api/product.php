<?php

/*
All mapping URLs in the Router/api directory must have the "/api" prefix before the URL.
*/
return [
    'name' => 'api.product',
    'middlewares' => [
        'checkLogin:1:2'
    ],
    'routes' => [
        '/api/products' => [
            'handler' => [\Http\Controllers\Api\ProductController::class, 'index'],
        ],
        '/api/products/{slug}.html' => [
            'handler' => [\Http\Controllers\Api\ProductController::class, 'detail'],
        ],
        '/api/products/create' => [
            'handler' => [\Http\Controllers\Api\ProductController::class, 'create'],
        ]
    ]
];
