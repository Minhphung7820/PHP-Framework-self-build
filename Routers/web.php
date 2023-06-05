<?php
return [
    'middlewares' => [],
    'name' => 'web',
    'routes' => [
        '/' => [
            'handler' => [\Http\Controllers\Frontend\HomeController::class, 'index'],

        ],
        '/san-pham/{cate}/{slug}.html' => [
            'handler' => [\Http\Controllers\Frontend\ProductController::class, 'detail'],
            'middlewares' => ['checkLogin:1:1', 'checkRole:4'],
        ],
        '/san-pham' => [
            'handler' => [\Http\Controllers\Frontend\ProductController::class, 'all'],
            'middlewares' => ['checkLogin:1:123', 'checkRole:4'],
        ],
        '/lien-he' => [
            'handler' => function () {
                return view('frontend.contact.index');
            },
        ]
    ]
];
