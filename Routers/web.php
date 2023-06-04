<?php
return [
    'middlewares' => ['checkLogin', 'checkRole'],
    'name' => 'web',
    'routes' => [
        '/' => [
            'handler' => [\Http\Controllers\Frontend\HomeController::class, 'index'],

        ],
        '/san-pham/{cate}/{slug}.html' => [
            'handler' => [\Http\Controllers\Frontend\ProductController::class, 'detail'],
            // 'middlewares' => ['checkLogin', 'checkRole'],
        ],
        '/san-pham' => [
            'handler' => [\Http\Controllers\Frontend\ProductController::class, 'all'],
        ],
        '/lien-he' => [
            'handler' => function () {
                return view('frontend.contact.index');
            },
        ]
    ]
];
